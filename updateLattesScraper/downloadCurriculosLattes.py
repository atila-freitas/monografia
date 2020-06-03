import requests
from PIL import Image
from io import BytesIO
import time
import breaker
import six

id_cnpq = "7227955029154651"
captcha_solution = ""
correctAnswer = "erro"
session = requests.session()
while(correctAnswer.find("erro") > -1):
    ts = str(int(time.time()*1000))
    print(ts)
    urlImage = "http://buscatextual.cnpq.br/buscatextual/servlet/captcha?metodo=getImagemCaptcha&noCache=" + ts
    response = session.get(urlImage)
    cookies = 'fontSize=10; ' + response.headers['Set-Cookie']
    #print(cookies)
    im = Image.open(BytesIO(response.content))
    captcha_path = "%s.png" % id_cnpq
    im.save(captcha_path)
    captcha_solution = breaker.solve_captcha(captcha_path, 0,10, "Teste")
    print(captcha_solution)
    #print(cookies)
    urlToGetXML = "http://buscatextual.cnpq.br/buscatextual/servlet/captcha?informado="+captcha_solution+"&metodo=validaCaptcha"
    print(urlToGetXML)
    data = {"metodo" : "validaCaptcha", "idcnpq": "%s" % id_cnpq, "informado":captcha_solution}
    headers = {'Content-Type' : 'application/json', 'Host' : 'buscatextual.cnpq.br', 'X-Requested-With': 'XMLHttpRequest','Referer': 'http://buscatextual.cnpq.br/buscatextual/download.do?metodo=apresentar&idcnpq=%s'% id_cnpq, 'User-Agent': 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_6) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/12.1 Safari/605.1.15'}
    response = session.get(urlToGetXML, headers=headers, allow_redirects=True, stream=True)
    cookies = session.cookies['JSESSIONID']
    correctAnswer = response.text
    cookieReal = "dtCookie="+ session.cookies['dtCookie'] + ";BIGipServerpool_buscatextual.cnpq.br=" + session.cookies['BIGipServerpool_buscatextual.cnpq.br'] + ";TSc7134d=" + session.cookies['TSc7134d'] + ";jssesionid=" + session.cookies['JSESSIONID'] + ";TSb1bf90=" + session.cookies['TSb1bf90'] + ";TSb1bf90=" + session.cookies['TSb1bf90'] 
    print(cookieReal)
    if(correctAnswer.find("erro") == -1):
        data = {"metodo" : "captchaValido", "idcnpq": "%s" % id_cnpq, "informado":""}
        dataXml = requests.Request('POST', 'http://buscatextual.cnpq.br/buscatextual/download.do;jsessionid=' + str(cookies), headers=headers, files=data).prepare().body.decode('utf8')
        #print(dataXml)
        urlGeral = "http://buscatextual.cnpq.br/buscatextual/download.do;jsessionid=" + str(cookies) 
        print(urlGeral)
        print(dataXml[:34])
        headers = {"Cookie": cookieReal, "Host" : "buscatextual.cnpq.br","User-Agent" : "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_6) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/12.1 Safari/605.1.15", "Referer":"http://buscatextual.cnpq.br/buscatextual/download.do?metodo=apresentar&idcnpq=%s" % id_cnpq}
        responseActual = requests.post(urlGeral, data=data, headers=headers, stream=True)
        print(responseActual)
        with open('my_file.zip', 'wb') as file_handle:
            chunk_size = 8096
            bytes_transferred = 0
            for chunk in responseActual.iter_content(chunk_size):
                file_handle.write(six.b(chunk))
                bytes_transferred += len(chunk)
                print("Downloaded {0} bytes".format(bytes_transferred))
#with open('data.xml', 'w') as f:
    #f.write(response.text)