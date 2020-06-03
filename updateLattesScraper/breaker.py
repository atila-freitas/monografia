#!/usr/bin/env python
# -*- coding: utf-8 -*-
import requests
import time 
import json
import base64
import string
import urllib3
import random
urllib3.disable_warnings()
requests.packages.urllib3.disable_warnings()

anticaptcha_debug = '/tmp/anticaptcha_stats.json'

def solve_captcha(captcha_path, min_length, max_length, plate):
    # anticaptcha account key
    key = ''
    with open(captcha_path, "rb") as image_file:
        b64image = base64.b64encode(image_file.read()) # Must convert to base64 image
        b64image = b64image.decode()
    print("[%s] Captcha image converted to base64" % plate)    
    create_task_url = "https://api.anti-captcha.com/createTask"
    create_task = json.dumps({ 
        "clientKey": key,
        "task": {
            "type": "ImageToTextTask",
            "body": str(b64image),
            "phrase": "false",
            "case": "false",
            "numeric": "true",
            "math": 0,
            "minLength": min_length,
            "maxLength": max_length
        }
    })
    # sending captcha and creating task
    r = requests.post(create_task_url, data=create_task)
    print("[%s] Captcha sent to anticaptcha. Waiting..." % plate)
    # getting answer
    answer = json.loads(r.text)
    if answer['errorId'] == 0:
        task_id = answer['taskId']
        print("[%s] Task ID: %s" % (plate, task_id))
    else:
        print('[%s] Anticaptcha Error:\n\t%d\n\t%s\n\t%s'
        % (plate, answer['errorId'], answer['errorCode'], answer['errorDescription']))
        with open(anticaptcha_debug, 'a') as f:
            json.dump(answer, f) # writing log for anticaptcha
            f.write('\n')
        # If any errors, return a random string
        #rdnm = ''.join(random.choice(string.ascii_uppercase + string.digits) for x in range(8))
        #print('[x] Returning a random string: %s' % rdnm) 
        #return rdnm
        print('[%s] Returning None' % plate)
        return None
    get_task_result_url = "https://api.anti-captcha.com/getTaskResult"
    task_result = json.dumps({
        "clientKey": key,
        "taskId": task_id
    })
    result = {'status': None}
    count = 1
    print("[%s] Waiting for anticaptcha solution..." % (plate))
    while result['status'] != 'ready':
        r = requests.post(get_task_result_url, data=task_result, verify=False)
        result = json.loads(r.text)
        if 'status' not in result.keys():
            print(r.text)
            result = {'status': None}
        time.sleep(1)
        count += 1
    with open(anticaptcha_debug, 'a') as f:
        json.dump(result, f) # writing log for anticaptcha
        f.write('\n')
    solution = result['solution']['text']
    print ('\n[%s] Anticaptcha retrieved solution: %s' % (plate, solution))
    return solution



def solve_recaptcha(plate, site_url, site_key):
    # anticaptcha account key
    key = ''
    create_task_url = "https://api.anti-captcha.com/createTask"
    create_task = json.dumps({ 
        "clientKey": key,
        "task": {
            "type": "NoCaptchaTaskProxyless",
            "websiteURL": site_url,
            "websiteKey": site_key
        }
    })
    # sending captcha and creating task
    r = requests.post(create_task_url, data=create_task)
    print("[%s] ReCaptcha sent to anticaptcha. Waiting..." % plate)
    # getting answer
    answer = json.loads(r.text)
    if answer['errorId'] == 0:
        task_id = answer['taskId']
        print("[%s] Task ID: %s" % (plate, task_id))
    else:
        print('[{}] ReCaptcha Anticaptcha Error:\n\t{}\n\t{}\n\t{}'\
        .format(plate, answer['errorId'], answer['errorCode'], answer['errorDescription']))
        with open(anticaptcha_debug, 'a') as f:
            json.dump(answer, f) # writing log for anticaptcha
            f.write('\n')
        print('[%s] Returning None' % plate)
        return None
    
    get_task_result_url = "https://api.anti-captcha.com/getTaskResult"
    task_result = json.dumps({
        "clientKey": key,
        "taskId": task_id
    })
    
    sucess = False
    while not sucess:
        time.sleep(3)
        r = requests.post(get_task_result_url, data=task_result, verify=False)
        result = json.loads(r.text)
        if result['errorId'] != 0:
            print("[{}] Anticaptcha error:\n{}".format(plate, result))
            return None
        elif 'status' in result.keys() and result['status'] == 'ready':
            print('[{}] Anticaptcha retrieved solution for recaptcha.'.format(plate))
            sucess = True
    with open(anticaptcha_debug, 'a') as f:
        json.dump(result, f) # writing log for anticaptcha
        f.write('\n')
    solution = result['solution']['gRecaptchaResponse']
    return solution
