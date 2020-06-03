#!/usr/bin/env python
# -*- coding: utf-8 -*-
import mysql.connector
from datetime import datetime
import json

mydb = mysql.connector.connect(
  host="localhost",
  user="root",
  passwd="asclepiades92",
  database="gis"
)

mycursor = mydb.cursor()

def get_centers(count):
    if(count == "count=true" or count == "count=True"):
        mycursor.execute("SELECT COUNT(*) FROM centros_faculdades")
        return mycursor.fetchone()[0]
    else:
        mycursor.execute("SELECT * FROM centros_faculdades ORDER BY nome")
    row_headers=[x[0] for x in mycursor.description] #this will extract row headers
    rv = mycursor.fetchall()
    json_response = {}
    json_data=[]
    keys_to_update = ['created_at', 'updated_at', 'data_atualizacao']
    json_response['count'] = len(rv)
    if(len(rv) == 0):
        json_response['results'] = json_data
        return json_response
    for result in rv:
        #print(dict(zip(row_headers,result)))
        jsonRow = dict(zip(row_headers,result))
        #print(jsonRow['created_at'])
        for key in keys_to_update:
            if key in jsonRow and isinstance(jsonRow[key], datetime):
                jsonRow[key] = jsonRow[key].strftime('%Y-%m-%d %H:%M:%S')
        json_data.append(jsonRow)
    json_response['results'] = json_data
    return json_response

def get_center_id(json):
    sql = ''
    for key in json:
        if(sql != ''):
            sql = sql + ' AND '
        sql = sql + key + " = \'" + json[key] + "\'"
    try:
        mycursor.execute("SELECT id FROM centros_faculdades WHERE %s" %sql)
    except Exception:
        return None
    row_headers=[x[0] for x in mycursor.description] #this will extract row headers
    rv = mycursor.fetchall()
    return rv[0]

def get_center_specific(id, count):
    if(count == "count=true" or count == "count=True"):
        mycursor.execute("SELECT COUNT(*) FROM centros_faculdades WHERE id = %s" % id)
        return mycursor.fetchone()[0]
    else:
        mycursor.execute("SELECT * FROM centros_faculdades WHERE id = %s" % id)
    row_headers=[x[0] for x in mycursor.description] #this will extract row headers
    rv = mycursor.fetchall()
    json_response = {}
    json_data=[]
    keys_to_update = ['created_at', 'updated_at', 'data_atualizacao']
    json_response['count'] = len(rv)
    if(len(rv) == 0):
        json_response['results'] = json_data
        return json_response
    for result in rv:
        jsonRow = dict(zip(row_headers,result))
        for key in keys_to_update:
            if key in jsonRow and isinstance(jsonRow[key], datetime):
                jsonRow[key] = jsonRow[key].strftime('%Y-%m-%d %H:%M:%S')
        json_data.append(jsonRow)
    json_response['results'] = json_data
    return json_response

def get_teachers(count):
    if(count == "count=true" or count == "count=True"):
        mycursor.execute("SELECT COUNT(*) FROM cursos_faculdade curf LEFT JOIN centros_faculdades cenf ON cenf.id = curf.centro_faculdade_id LEFT JOIN lattes l ON l.curso_faculdade_id = curf.id")
        return mycursor.fetchone()[0]
    else:
        mycursor.execute("SELECT l.id, l.curso_faculdade_id, l.nacionalidade, l.data_atualizacao as data_atualizacao, l.nome_completo, l.nome_citacao, cenf.nome as nome_centro, cenf.sigla as sigla_centro, curf.nome as nome_curso FROM cursos_faculdade curf LEFT JOIN centros_faculdades cenf ON cenf.id = curf.centro_faculdade_id LEFT JOIN lattes l ON l.curso_faculdade_id = curf.id ORDER BY nome_completo")
    row_headers=[x[0] for x in mycursor.description] #this will extract row headers
    rv = mycursor.fetchall()
    json_response = {}
    json_data=[]
    keys_to_update = ['created_at', 'updated_at', 'data_atualizacao']
    json_response['count'] = len(rv)
    if(len(rv) == 0):
        json_response['results'] = json_data
        return json_response
    for result in rv:
        jsonRow = dict(zip(row_headers,result))
        for key in keys_to_update:
            if key in jsonRow and isinstance(jsonRow[key], datetime):
                jsonRow[key] = jsonRow[key].strftime('%Y-%m-%d %H:%M:%S')
        json_data.append(jsonRow)
    json_response['results'] = json_data
    return json_response

def get_teacher_id(json):
    sql = ''
    for key in json:
        if(sql != ''):
            sql = sql + ' AND '
        sql = sql + key + " = \'" + json[key] + "\'"
    try:
        mycursor.execute("SELECT id FROM lattes WHERE %s" %sql)
    except Exception:
        return None
    row_headers=[x[0] for x in mycursor.description] #this will extract row headers
    rv = mycursor.fetchall()
    return rv[0]

def get_teacher_statistics(limit):
    mycursor.execute("SELECT artp.lattes_id, COUNT(artp.lattes_id) AS ART, MAX(l.nome_completo) as nome_completo FROM artigos_publicados artp INNER JOIN lattes l ON l.id = artp.lattes_id GROUP by artp.lattes_id ORDER BY ART DESC LIMIT 10")
    row_headers=[x[0] for x in mycursor.description] #this will extract row headers
    rv = mycursor.fetchall()
    json_response = {}
    json_data=[]
    keys_to_update = ['created_at', 'updated_at', 'data_atualizacao']
    json_response['count'] = len(rv)
    if(len(rv) == 0):
        json_response['articles'] = json_data
        return json_response
    for result in rv:
        jsonRow = dict(zip(row_headers,result))
        for key in keys_to_update:
            if key in jsonRow and isinstance(jsonRow[key], datetime):
                jsonRow[key] = jsonRow[key].strftime('%Y-%m-%d %H:%M:%S')
        json_data.append(jsonRow)
    json_response['articles'] = json_data
    mycursor.execute("SELECT artp.lattes_id, COUNT(artp.lattes_id) AS ART, MAX(l.nome_completo) as nome_completo FROM trabalhos_em_eventos artp INNER JOIN lattes l ON l.id = artp.lattes_id GROUP by artp.lattes_id ORDER BY ART DESC LIMIT 10")
    row_headers=[x[0] for x in mycursor.description] #this will extract row headers
    rv = mycursor.fetchall()
    json_data=[]
    keys_to_update = ['created_at', 'updated_at', 'data_atualizacao']
    json_response['count'] = len(rv)
    if(len(rv) == 0):
        json_response['events'] = json_data
        return json_response
    for result in rv:
        jsonRow = dict(zip(row_headers,result))
        for key in keys_to_update:
            if key in jsonRow and isinstance(jsonRow[key], datetime):
                jsonRow[key] = jsonRow[key].strftime('%Y-%m-%d %H:%M:%S')
        json_data.append(jsonRow)
    json_response['events'] = json_data
    mycursor.execute("SELECT artp.lattes_id, COUNT(artp.lattes_id) AS ART, MAX(l.nome_completo) as nome_completo FROM capitulos_de_livros_publicados artp INNER JOIN lattes l ON l.id = artp.lattes_id GROUP by artp.lattes_id ORDER BY ART DESC LIMIT 10")
    row_headers=[x[0] for x in mycursor.description] #this will extract row headers
    rv = mycursor.fetchall()
    json_data=[]
    keys_to_update = ['created_at', 'updated_at', 'data_atualizacao']
    json_response['count'] = len(rv)
    if(len(rv) == 0):
        json_response['books'] = json_data
        return json_response
    for result in rv:
        jsonRow = dict(zip(row_headers,result))
        for key in keys_to_update:
            if key in jsonRow and isinstance(jsonRow[key], datetime):
                jsonRow[key] = jsonRow[key].strftime('%Y-%m-%d %H:%M:%S')
        json_data.append(jsonRow)
    json_response['books'] = json_data
    return json_response

def get_teachers_details(id):
    mycursor.execute("SELECT * FROM lattes WHERE lattes.id = %s" %id)
    row_headers=[x[0] for x in mycursor.description] #this will extract row headers
    rv = mycursor.fetchall()
    json_response = {}
    json_data=[]
    keys_to_update = ['created_at', 'updated_at', 'data_atualizacao']
    json_response['count'] = len(rv)
    if(len(rv) == 0):
        json_response['results'] = json_data
        return json_response
    for result in rv:
        jsonRow = dict(zip(row_headers,result))
        for key in keys_to_update:
            if key in jsonRow and isinstance(jsonRow[key], datetime):
                jsonRow[key] = jsonRow[key].strftime('%Y-%m-%d %H:%M:%S')
        json_data.append(jsonRow)
    json_response['results'] = json_data
    print(json_response['results'])
    mycursor.execute("SELECT * FROM centros_faculdades WHERE centros_faculdades.id IN ( SELECT cursos_faculdade.centro_faculdade_id FROM `cursos_faculdade` WHERE cursos_faculdade.id = %s)" % json_response['results'][0]['curso_faculdade_id'])
    row_headers=[x[0] for x in mycursor.description] #this will extract row headers
    rv = mycursor.fetchall()
    json_data=[]
    for result in rv:
        jsonRow = dict(zip(row_headers,result))
        for key in keys_to_update:
            if key in jsonRow and isinstance(jsonRow[key], datetime):
                jsonRow[key] = jsonRow[key].strftime('%Y-%m-%d %H:%M:%S')
        json_data.append(jsonRow)
    json_response['centro'] = json_data
    mycursor.execute("SELECT * FROM artigos_publicados WHERE artigos_publicados.lattes_id = %s" % id)
    row_headers=[x[0] for x in mycursor.description] #this will extract row headers
    rv = mycursor.fetchall()
    json_data=[]
    for result in rv:
        jsonRow = dict(zip(row_headers,result))
        for key in keys_to_update:
            if key in jsonRow and isinstance(jsonRow[key], datetime):
                jsonRow[key] = jsonRow[key].strftime('%Y-%m-%d %H:%M:%S')
        json_data.append(jsonRow)
    json_response['artigos'] = json_data
    mycursor.execute("SELECT * FROM trabalhos_em_eventos WHERE trabalhos_em_eventos.lattes_id= %s" % id)
    row_headers=[x[0] for x in mycursor.description] #this will extract row headers
    rv = mycursor.fetchall()
    json_data=[]
    for result in rv:
        jsonRow = dict(zip(row_headers,result))
        for key in keys_to_update:
            if key in jsonRow and isinstance(jsonRow[key], datetime):
                jsonRow[key] = jsonRow[key].strftime('%Y-%m-%d %H:%M:%S')
        json_data.append(jsonRow)
    json_response['trabalhosEventos'] = json_data
    mycursor.execute("SELECT * FROM capitulos_de_livros_publicados WHERE capitulos_de_livros_publicados.lattes_id = %s" % id)
    row_headers=[x[0] for x in mycursor.description] #this will extract row headers
    rv = mycursor.fetchall()
    json_data=[]
    for result in rv:
        jsonRow = dict(zip(row_headers,result))
        for key in keys_to_update:
            if key in jsonRow and isinstance(jsonRow[key], datetime):
                jsonRow[key] = jsonRow[key].strftime('%Y-%m-%d %H:%M:%S')
        json_data.append(jsonRow)
    json_response['capLivrosPub'] = json_data
    return json_response      

def get_teachers_from_center(id, count):
    if(count == "count=true" or count == "count=True"):
        mycursor.execute("SELECT COUNT(*) FROM cursos_faculdade curf LEFT JOIN centros_faculdades cenf ON cenf.id = curf.centro_faculdade_id LEFT JOIN lattes l ON l.curso_faculdade_id = curf.id WHERE cenf.id = %s" % id)
        return mycursor.fetchone()[0]
    else:
        mycursor.execute("SELECT l.id as lattes_id, l.nome_completo, l.nome_citacao, cenf.nome as nome_centro, cenf.sigla as sigla_centro, curf.nome as nome_curso FROM cursos_faculdade curf LEFT JOIN centros_faculdades cenf ON cenf.id = curf.centro_faculdade_id LEFT JOIN lattes l ON l.curso_faculdade_id = curf.id WHERE cenf.id = %s" % id)
    row_headers=[x[0] for x in mycursor.description] #this will extract row headers
    rv = mycursor.fetchall()
    json_response = {}
    json_data=[]
    json_response['count'] = len(rv)
    if(len(rv) == 0):
        json_response['results'] = json_data
        return json_response
    for result in rv:
        jsonRow = dict(zip(row_headers,result))
        json_data.append(jsonRow)
    json_response['results'] = json_data
    return json_response

def get_university_courses(count):
    if(count == "count=true" or count == "count=True"):
        mycursor.execute("SELECT COUNT(*) FROM cursos_faculdade curf LEFT JOIN centros_faculdades cenf ON cenf.id = curf.centro_faculdade_id")
        return mycursor.fetchone()[0]
    else:
        mycursor.execute("SELECT curf.id, curf.nome as nome_curso, cenf.nome as nome_centro, cenf.sigla as sigla_centro, cenf.tipo as tipo_centro FROM cursos_faculdade curf LEFT JOIN centros_faculdades cenf ON cenf.id = curf.centro_faculdade_id")
    row_headers=[x[0] for x in mycursor.description] #this will extract row headers
    rv = mycursor.fetchall()
    json_response = {}
    json_data=[]
    json_response['count'] = len(rv)
    if(len(rv) == 0):
        json_response['results'] = json_data
        return json_response
    for result in rv:
        jsonRow = dict(zip(row_headers,result))
        json_data.append(jsonRow)
    json_response['results'] = json_data
    return json_response

def get_university_courses_from_center(id, count):
    if(count == "count=true" or count == "count=True"):
        mycursor.execute("SELECT COUNT(*) FROM cursos_faculdade curf LEFT JOIN centros_faculdades cenf ON cenf.id = curf.centro_faculdade_id WHERE cenf.id = %s" %id)
        return mycursor.fetchone()[0]
    else:
        mycursor.execute("SELECT curf.nome as nome_curso, cenf.nome as nome_centro, cenf.sigla as sigla_centro, cenf.tipo as tipo_centro FROM cursos_faculdade curf LEFT JOIN centros_faculdades cenf ON cenf.id = curf.centro_faculdade_id WHERE cenf.id = %s" %id)
    row_headers=[x[0] for x in mycursor.description] #this will extract row headers
    rv = mycursor.fetchall()
    json_response = {}
    json_data=[]
    json_response['count'] = len(rv)
    if(len(rv) == 0):
        json_response['results'] = json_data
        return json_response
    for result in rv:
        jsonRow = dict(zip(row_headers,result))
        json_data.append(jsonRow)
    json_response['results'] = json_data
    return json_response

def get_published_articles_without_qualis():
    mycursor.execute("SELECT COUNT(*) FROM artigos_publicados artp WHERE estrato IS NULL")
    return mycursor.fetchone()[0]

def get_published_articles(count):
    if(count == "count=true" or count == "count=True"):
        mycursor.execute("SELECT COUNT(*) FROM artigos_publicados artp WHERE artp.lattes_id IN ( SELECT id from lattes l WHERE l.curso_faculdade_id in (SELECT curf.id FROM cursos_faculdade curf ))")
        return mycursor.fetchone()[0]
    else:
        mycursor.execute("SELECT * FROM artigos_publicados artp WHERE artp.lattes_id IN ( SELECT id from lattes l WHERE l.curso_faculdade_id in (SELECT curf.id FROM cursos_faculdade curf ))")
    row_headers=[x[0] for x in mycursor.description] #this will extract row headers
    rv = mycursor.fetchall()
    json_response = {}
    json_data=[]
    keys_to_update = ['created_at', 'updated_at', 'data_atualizacao']
    json_response['count'] = len(rv)
    if(len(rv) == 0):
        json_response['results'] = json_data
        return json_response
    for result in rv:
        jsonRow = dict(zip(row_headers,result))
        for key in keys_to_update:
            if key in jsonRow and isinstance(jsonRow[key], datetime):
                jsonRow[key] = jsonRow[key].strftime('%Y-%m-%d %H:%M:%S')
        json_data.append(jsonRow)
    json_response['results'] = json_data
    return json_response

def get_published_articles_from_center(id, count):
    if(count == "count=true" or count == "count=True"):
        mycursor.execute("SELECT COUNT(*) FROM artigos_publicados artp WHERE artp.lattes_id IN ( SELECT id from lattes l WHERE l.curso_faculdade_id in (SELECT curf.id FROM cursos_faculdade curf WHERE curf.centro_faculdade_id = %s ))" %id)
        return mycursor.fetchone()[0]
    else:
        mycursor.execute("SELECT * FROM artigos_publicados artp WHERE artp.lattes_id IN ( SELECT id from lattes l WHERE l.curso_faculdade_id in (SELECT curf.id FROM cursos_faculdade curf WHERE curf.centro_faculdade_id = %s ))" %id)
    row_headers=[x[0] for x in mycursor.description] #this will extract row headers
    rv = mycursor.fetchall()
    json_response = {}
    json_data=[]
    keys_to_update = ['created_at', 'updated_at', 'data_atualizacao']
    json_response['count'] = len(rv)
    if(len(rv) == 0):
        json_response['results'] = json_data
        return json_response
    for result in rv:
        jsonRow = dict(zip(row_headers,result))
        for key in keys_to_update:
            if key in jsonRow and isinstance(jsonRow[key], datetime):
                jsonRow[key] = jsonRow[key].strftime('%Y-%m-%d %H:%M:%S')
        json_data.append(jsonRow)
    json_response['results'] = json_data
    return json_response

def get_published_articles_from_center_statistics(id):
    mycursor.execute("SELECT ano_do_artigo, count(ano_do_artigo) AS count FROM artigos_publicados WHERE artigos_publicados.lattes_id IN ( SELECT id from lattes WHERE lattes.curso_faculdade_id in (SELECT cursos_faculdade.id FROM `cursos_faculdade` WHERE cursos_faculdade.centro_faculdade_id = %s)) GROUP BY ano_do_artigo" %id)
    row_headers=[x[0] for x in mycursor.description] #this will extract row headers
    rv = mycursor.fetchall()
    json_response = {}
    json_data=[]
    json_response['count'] = len(rv)
    if(len(rv) == 0):
        json_response['articles'] = json_data
        return json_response
    for result in rv:
        jsonRow = dict(zip(row_headers,result))
        json_data.append(jsonRow)
    json_response['articles'] = json_data
    mycursor.execute("SELECT ano, count(ano) AS count FROM capitulos_de_livros_publicados WHERE capitulos_de_livros_publicados.ano > 1900  AND capitulos_de_livros_publicados.lattes_id IN ( SELECT id from lattes WHERE lattes.curso_faculdade_id in (SELECT cursos_faculdade.id FROM `cursos_faculdade` WHERE cursos_faculdade.centro_faculdade_id = %s)) GROUP BY capitulos_de_livros_publicados.ano" %id)
    row_headers=[x[0] for x in mycursor.description] #this will extract row headers
    rv = mycursor.fetchall()
    json_data=[]
    json_response['count'] = len(rv)
    if(len(rv) == 0):
        json_response['books'] = json_data
        return json_response
    for result in rv:
        jsonRow = dict(zip(row_headers,result))
        json_data.append(jsonRow)
    json_response['books'] = json_data
    mycursor.execute("SELECT ano, count(ano) AS count FROM trabalhos_em_eventos WHERE trabalhos_em_eventos.ano > 1900  AND trabalhos_em_eventos.lattes_id IN ( SELECT id from lattes WHERE lattes.curso_faculdade_id in (SELECT cursos_faculdade.id FROM `cursos_faculdade` WHERE cursos_faculdade.centro_faculdade_id = %s)) GROUP BY trabalhos_em_eventos.ano" %id)
    row_headers=[x[0] for x in mycursor.description] #this will extract row headers
    rv = mycursor.fetchall()
    json_data=[]
    json_response['count'] = len(rv)
    if(len(rv) == 0):
        json_response['events'] = json_data
        return json_response
    for result in rv:
        jsonRow = dict(zip(row_headers,result))
        json_data.append(jsonRow)
    json_response['events'] = json_data
    return json_response

def get_events_works(count):
    if(count == "count=true" or count == "count=True"):
        mycursor.execute("SELECT COUNT(*) FROM trabalhos_em_eventos te WHERE te.lattes_id IN ( SELECT id from lattes l WHERE l.curso_faculdade_id in (SELECT curf.id FROM cursos_faculdade curf))")
        return mycursor.fetchone()[0]
    else:
        mycursor.execute("SELECT * FROM trabalhos_em_eventos te WHERE te.lattes_id IN ( SELECT id from lattes l WHERE l.curso_faculdade_id in (SELECT curf.id FROM cursos_faculdade curf))")
    row_headers=[x[0] for x in mycursor.description] #this will extract row headers
    rv = mycursor.fetchall()
    json_response = {}
    json_data=[]
    keys_to_update = ['created_at', 'updated_at', 'data_atualizacao']
    json_response['count'] = len(rv)
    if(len(rv) == 0):
        json_response['results'] = json_data
        return json_response
    for result in rv:
        jsonRow = dict(zip(row_headers,result))
        for key in keys_to_update:
            if key in jsonRow and isinstance(jsonRow[key], datetime):
                jsonRow[key] = jsonRow[key].strftime('%Y-%m-%d %H:%M:%S')
        json_data.append(jsonRow)
    json_response['results'] = json_data
    return json_response

def get_events_works_from_center(id, count):
    if(count == "count=true" or count == "count=True"):
        mycursor.execute("SELECT COUNT(*) FROM trabalhos_em_eventos te WHERE te.lattes_id IN ( SELECT id from lattes l WHERE l.curso_faculdade_id in (SELECT curf.id FROM cursos_faculdade curf WHERE curf.centro_faculdade_id = %s))" %id)
        return mycursor.fetchone()[0]
    else:
        mycursor.execute("SELECT * FROM trabalhos_em_eventos te WHERE te.lattes_id IN ( SELECT id from lattes l WHERE l.curso_faculdade_id in (SELECT curf.id FROM cursos_faculdade curf WHERE curf.centro_faculdade_id = %s))" %id)
    row_headers=[x[0] for x in mycursor.description] #this will extract row headers
    rv = mycursor.fetchall()
    json_response = {}
    json_data=[]
    keys_to_update = ['created_at', 'updated_at', 'data_atualizacao']
    json_response['count'] = len(rv)
    if(len(rv) == 0):
        json_response['results'] = json_data
        return json_response
    for result in rv:
        jsonRow = dict(zip(row_headers,result))
        for key in keys_to_update:
            if key in jsonRow and isinstance(jsonRow[key], datetime):
                jsonRow[key] = jsonRow[key].strftime('%Y-%m-%d %H:%M:%S')
        json_data.append(jsonRow)
    json_response['results'] = json_data
    return json_response

def get_published_cap_books(count):
    if(count == "count=true" or count == "count=True"):
        mycursor.execute("SELECT COUNT(*) FROM capitulos_de_livros_publicados clp WHERE clp.lattes_id IN ( SELECT id from lattes l WHERE l.curso_faculdade_id in (SELECT curf.id FROM cursos_faculdade curf ))")
        return mycursor.fetchone()[0]
    else:
        mycursor.execute("SELECT * FROM capitulos_de_livros_publicados clp WHERE clp.lattes_id IN ( SELECT id from lattes l WHERE l.curso_faculdade_id in (SELECT curf.id FROM cursos_faculdade curf ))")
    row_headers=[x[0] for x in mycursor.description] #this will extract row headers
    rv = mycursor.fetchall()
    json_response = {}
    json_data=[]
    keys_to_update = ['created_at', 'updated_at', 'data_atualizacao']
    json_response['count'] = len(rv)
    if(len(rv) == 0):
        json_response['results'] = json_data
        return json_response
    for result in rv:
        jsonRow = dict(zip(row_headers,result))
        for key in keys_to_update:
            if key in jsonRow and isinstance(jsonRow[key], datetime):
                jsonRow[key] = jsonRow[key].strftime('%Y-%m-%d %H:%M:%S')
        json_data.append(jsonRow)
    json_response['results'] = json_data
    return json_response

def get_published_cap_books_from_center(id, count):
    if(count == "count=true" or count == "count=True"):
        mycursor.execute("SELECT COUNT(*) FROM capitulos_de_livros_publicados clp WHERE clp.lattes_id IN ( SELECT id from lattes l WHERE l.curso_faculdade_id in (SELECT curf.id FROM cursos_faculdade curf WHERE curf.centro_faculdade_id = %s))" %id)
        return mycursor.fetchone()[0]
    else:
        mycursor.execute("SELECT * FROM capitulos_de_livros_publicados clp WHERE clp.lattes_id IN ( SELECT id from lattes l WHERE l.curso_faculdade_id in (SELECT curf.id FROM cursos_faculdade curf WHERE curf.centro_faculdade_id = %s))" %id)
    row_headers=[x[0] for x in mycursor.description] #this will extract row headers
    rv = mycursor.fetchall()
    json_response = {}
    json_data=[]
    keys_to_update = ['created_at', 'updated_at', 'data_atualizacao']
    json_response['count'] = len(rv)
    if(len(rv) == 0):
        json_response['results'] = json_data
        return json_response
    for result in rv:
        jsonRow = dict(zip(row_headers,result))
        for key in keys_to_update:
            if key in jsonRow and isinstance(jsonRow[key], datetime):
                jsonRow[key] = jsonRow[key].strftime('%Y-%m-%d %H:%M:%S')
        json_data.append(jsonRow)
    json_response['results'] = json_data
    return json_response

def get_articles_years():
    mycursor.execute("SELECT DISTINCT ap.ano_do_artigo FROM artigos_publicados ap LEFT JOIN lattes l ON l.id = ap.lattes_id LEFT JOIN cursos_faculdade curf ON curf.id = l.curso_faculdade_id LEFT JOIN centros_faculdades cenf ON centro_faculdade_id = curf.centro_faculdade_id ORDER BY ap.ano_do_artigo")
    row_headers=[x[0] for x in mycursor.description] #this will extract row headers
    rv = mycursor.fetchall()
    json_response = {}
    json_data=[]
    json_response['count'] = len(rv)
    if(len(rv) == 0):
        json_response['results'] = json_data
        return json_response
    for result in rv:
        json_data.append(result[0])
    json_response['results'] = json_data
    return json_response

def get_articles_years_from_center(id):
    mycursor.execute("SELECT DISTINCT ap.ano_do_artigo FROM artigos_publicados ap LEFT JOIN lattes l ON l.id = ap.lattes_id LEFT JOIN cursos_faculdade curf ON curf.id = l.curso_faculdade_id LEFT JOIN centros_faculdades cenf ON centro_faculdade_id = curf.centro_faculdade_id WHERE cenf.id = %s ORDER BY ap.ano_do_artigo" %id)
    row_headers=[x[0] for x in mycursor.description] #this will extract row headers
    rv = mycursor.fetchall()
    json_response = {}
    json_data=[]
    json_response['count'] = len(rv)
    if(len(rv) == 0):
        json_response['results'] = json_data
        return json_response
    for result in rv:
        json_data.append(result[0])
    json_response['results'] = json_data
    return json_response

def get_qualis_statistics_by_rank(rank):
    mycursor.execute("SELECT estrato, ano_do_artigo, count(ano_do_artigo) as count FROM `artigos_publicados` where estrato = \'%s\' GROUP by ano_do_artigo, estrato" %rank)
    row_headers=[x[0] for x in mycursor.description] #this will extract row headers
    rv = mycursor.fetchall()
    json_response = {}
    json_data=[]
    json_response['count'] = len(rv)
    if(len(rv) == 0):
        json_response['results'] = json_data
        return json_response
    for result in rv:
        jsonRow = dict(zip(row_headers,result))
        json_data.append(jsonRow)
    json_response['results'] = json_data
    return json_response

def get_qualis_statistics_by_center(id, year):
    mycursor.execute("SELECT ano_do_artigo, count(ano_do_artigo) as count, estrato FROM artigos_publicados WHERE artigos_publicados.ano_do_artigo = %s AND artigos_publicados.ano_do_artigo > 0 AND artigos_publicados.estrato IS NOT NULL AND artigos_publicados.lattes_id IN ( SELECT id from lattes WHERE lattes.curso_faculdade_id in (SELECT cursos_faculdade.id FROM `cursos_faculdade` WHERE cursos_faculdade.centro_faculdade_id = %s)) GROUP BY artigos_publicados.ano_do_artigo, artigos_publicados.estrato ORDER BY artigos_publicados.ano_do_artigo" % (year, id))
    row_headers=[x[0] for x in mycursor.description] #this will extract row headers
    rv = mycursor.fetchall()
    json_response = {}
    json_data=[]
    json_response['count'] = len(rv)
    if(len(rv) == 0):
        json_response['results'] = json_data
        return json_response
    for result in rv:
        jsonRow = dict(zip(row_headers,result))
        json_data.append(jsonRow)
    json_response['results'] = json_data
    return json_response
    
def get_qualis_statistics_by_year(year):
    mycursor.execute("SELECT  ano_do_artigo, count(ano_do_artigo) AS count, estrato FROM artigos_publicados WHERE estrato IS NOT NULL and ano_do_artigo = %s GROUP BY ano_do_artigo, estrato ORDER BY ano_do_artigo" %year)
    row_headers=[x[0] for x in mycursor.description] #this will extract row headers
    rv = mycursor.fetchall()
    json_response = {}
    json_data=[]
    json_response['count'] = len(rv)
    if(len(rv) == 0):
        json_response['results'] = json_data
        return json_response
    for result in rv:
        jsonRow = dict(zip(row_headers,result))
        json_data.append(jsonRow)
    json_response['results'] = json_data
    return json_response

def get_qualis_statistics():
    mycursor.execute("SELECT estrato, COUNT(estrato) as count FROM `artigos_publicados` WHERE estrato IS NOT NULL GROUP BY estrato")
    row_headers=[x[0] for x in mycursor.description] #this will extract row headers
    rv = mycursor.fetchall()
    json_response = {}
    json_data=[]
    json_response['count'] = len(rv)
    if(len(rv) == 0):
        json_response['results'] = json_data
        return json_response
    for result in rv:
        jsonRow = dict(zip(row_headers,result))
        json_data.append(jsonRow)
    json_response['results'] = json_data
    return json_response

def get_publish_statistics_by_year():
    mycursor.execute("SELECT  ano_do_artigo, count(ano_do_artigo) AS count FROM artigos_publicados GROUP BY ano_do_artigo ORDER BY ano_do_artigo")
    row_headers=[x[0] for x in mycursor.description] #this will extract row headers
    rv = mycursor.fetchall()
    json_response = {}
    json_data=[]
    json_response['count'] = len(rv)
    if(len(rv) == 0):
        json_response['articles'] = json_data
        return json_response
    for result in rv:
        jsonRow = dict(zip(row_headers,result))
        json_data.append(jsonRow)
    json_response['articles'] = json_data
    mycursor.execute("SELECT  ano, count(ano) AS count FROM trabalhos_em_eventos GROUP BY ano ORDER BY ano")
    row_headers=[x[0] for x in mycursor.description] #this will extract row headers
    rv = mycursor.fetchall()
    json_data=[]
    json_response['count'] = len(rv)
    if(len(rv) == 0):
        json_response['events'] = json_data
        return json_response
    for result in rv:
        jsonRow = dict(zip(row_headers,result))
        json_data.append(jsonRow)
    json_response['events'] = json_data
    mycursor.execute("SELECT ano, COUNT(ano) AS count FROM capitulos_de_livros_publicados GROUP BY ano ORDER BY ano")
    row_headers=[x[0] for x in mycursor.description] #this will extract row headers
    rv = mycursor.fetchall()
    json_data=[]
    json_response['count'] = len(rv)
    if(len(rv) == 0):
        json_response['books'] = json_data
        return json_response
    for result in rv:
        jsonRow = dict(zip(row_headers,result))
        json_data.append(jsonRow)
    json_response['books'] = json_data
    return json_response
