#!/usr/bin/env python
# -*- coding: UTF-8 -*-
# encoding=utf8 

import mysql.connector
from datetime import datetime
import json as json_module

mydb = mysql.connector.connect(
  host="localhost",
  user="root",
  passwd="asclepiades92",
  database="gis"
)

mycursor = mydb.cursor()

def get_paises(json):
    sql = ''
    for key in json:
        if(sql != ''):
            sql = sql + ' AND '
        else:
            sql = 'WHERE '
        sql = sql + key + " = \'" + json[key] + "\'"
    try:
        mycursor.execute("SELECT * FROM paises %s" %sql )
    except Exception:
        return None
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

def teachers_formation_statistics():
    json_response = {}
    mycursor.execute("SELECT id FROM lattes")
    row_headers=[x[0] for x in mycursor.description] #this will extract row headers
    rv = mycursor.fetchall()
    json_response['professores'] = len(rv)

    mycursor.execute("SELECT  lattes_id, count(codigo_instituicao) AS count FROM doutorados WHERE status_curso = \'CONCLUIDO\' GROUP BY lattes_id")
    row_headers=[x[0] for x in mycursor.description] #this will extract row headers
    rv = mycursor.fetchall()
    json_response['doutorado'] = len(rv)
    
    mycursor.execute("SELECT  lattes_id, count(codigo_instituicao) AS count FROM mestrados WHERE status_curso = \'CONCLUIDO\' GROUP BY lattes_id")
    row_headers=[x[0] for x in mycursor.description] #this will extract row headers
    rv = mycursor.fetchall()
    json_response['mestrado'] = len(rv)

    mycursor.execute("SELECT  lattes_id, count(codigo_instituicao) AS count FROM pos_doutorados WHERE status_curso = \'CONCLUIDO\' GROUP BY lattes_id")
    row_headers=[x[0] for x in mycursor.description] #this will extract row headers
    rv = mycursor.fetchall()
    json_response['posDoutorados'] = len(rv)

    mycursor.execute("SELECT  lattes_id, count(codigo_instituicao) AS count FROM graduacoes WHERE status_curso = \'CONCLUIDO\' GROUP BY lattes_id")
    row_headers=[x[0] for x in mycursor.description] #this will extract row headers
    rv = mycursor.fetchall()
    json_response['graduacao'] = len(rv)

    mycursor.execute("SELECT  lattes_id, count(codigo_instituicao) AS count FROM especializacoes GROUP BY lattes_id")
    row_headers=[x[0] for x in mycursor.description] #this will extract row headers
    rv = mycursor.fetchall()
    json_response['especialistas'] = len(rv)

    mycursor.execute("SELECT  lattes_id, count(codigo_instituicao) AS count FROM aperfeicoamentos GROUP BY lattes_id")
    row_headers=[x[0] for x in mycursor.description] #this will extract row headers
    rv = mycursor.fetchall()
    json_response['aperficoados'] = len(rv)

    mycursor.execute("SELECT  lattes_id, count(codigo_instituicao) AS count FROM mestrados_profissionalizantes WHERE status_curso = \'CONCLUIDO\' GROUP BY lattes_id")
    row_headers=[x[0] for x in mycursor.description] #this will extract row headers
    rv = mycursor.fetchall()
    json_response['mestradoProfissionalizante'] = len(rv)

    mycursor.execute("SELECT  lattes_id, count(codigo_instituicao) AS count FROM residencias_medicas GROUP BY lattes_id")
    row_headers=[x[0] for x in mycursor.description] #this will extract row headers
    rv = mycursor.fetchall()
    json_response['residencias_medicas'] = len(rv)

    mycursor.execute("SELECT  lattes_id, count(codigo_instituicao) AS count FROM livre_docencias GROUP BY lattes_id")
    row_headers=[x[0] for x in mycursor.description] #this will extract row headers
    rv = mycursor.fetchall()
    json_response['livre_docencia'] = len(rv)

    return json_response

def teacher_graduation(json):
    sql = ''
    for key in json:
        if(sql != ''):
            sql = sql + ' AND '
        else:
            sql = 'WHERE '
        if(json[key].__class__ == unicode):
            sql = sql + key + " = \'" + json[key] + "\'"
        else:
            json[key] = json_module.dumps(json[key], ensure_ascii=False).replace('[', '(').replace(']', ')')
            string_concat = [sql, key ," in "]
            sql = ' '.join(string_concat) + json[key]
    try:
        mycursor.execute("SELECT l.id, l.nome_completo as nome, inst.nome_pais, inst.sigla_pais, curf.nome AS curso_faculdade, curf.centro_faculdade_id, coord.latitude, coord.longitude,  g.nome_instituicao, g.nome_curso as curso,g.ano_conclusao as ano, g.ano_inicio, g.status_curso FROM graduacoes g LEFT JOIN lattes l ON (l.id = g.lattes_id)  LEFT JOIN cursos_faculdade curf ON (curf.id = l.curso_faculdade_id)LEFT JOIN instituicoes inst ON (inst.id = g.codigo_instituicao) LEFT JOIN coordenadas coord ON (coord.nome = g.nome_instituicao) %s" %sql )
    except Exception:
        return None
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

def teacher_aperfeicoa(json):
    sql = ''
    for key in json:
        if(sql != ''):
            sql = sql + ' AND '
        else:
            sql = 'WHERE '
        if(json[key].__class__ == unicode):
            sql = sql + key + " = \'" + json[key] + "\'"
        else:
            json[key] = json_module.dumps(json[key], ensure_ascii=False).replace('[', '(').replace(']', ')')
            string_concat = [sql, key ," in "]
            sql = ' '.join(string_concat) + json[key]
    try:
        mycursor.execute("SELECT l.id, l.nome_completo as nome, inst.nome_pais, inst.sigla_pais, curf.nome AS curso_faculdade, curf.centro_faculdade_id, coord.latitude, coord.longitude,  g.nome_instituicao, g.nome_curso as curso,g.ano_conclusao as ano, g.ano_inicio, g.status_curso FROM aperfeicoamentos g LEFT JOIN lattes l ON (l.id = g.lattes_id)  LEFT JOIN cursos_faculdade curf ON (curf.id = l.curso_faculdade_id)LEFT JOIN instituicoes inst ON (inst.id = g.codigo_instituicao) LEFT JOIN coordenadas coord ON (coord.nome = g.nome_instituicao) %s" %sql )
    except Exception:
        return None
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

def teacher_especializa(json):
    sql = ''
    for key in json:
        if(sql != ''):
            sql = sql + ' AND '
        else:
            sql = 'WHERE '
        if(json[key].__class__ == unicode):
            sql = sql + key + " = \'" + json[key] + "\'"
        else:
            json[key] = json_module.dumps(json[key], ensure_ascii=False).replace('[', '(').replace(']', ')')
            string_concat = [sql, key ," in "]
            sql = ' '.join(string_concat) + json[key]
    try:
        mycursor.execute("SELECT l.id, l.nome_completo as nome, inst.nome_pais, inst.sigla_pais, curf.nome AS curso_faculdade, curf.centro_faculdade_id, coord.latitude, coord.longitude,  g.nome_instituicao, g.nome_curso as curso,g.ano_conclusao as ano, g.ano_inicio, g.status_curso FROM especializacoes g LEFT JOIN lattes l ON (l.id = g.lattes_id)  LEFT JOIN cursos_faculdade curf ON (curf.id = l.curso_faculdade_id)LEFT JOIN instituicoes inst ON (inst.id = g.codigo_instituicao) LEFT JOIN coordenadas coord ON (coord.nome = g.nome_instituicao) %s" %sql )
    except Exception:
        return None
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

def teacher_master(json):
    sql = ''
    for key in json:
        if(sql != ''):
            sql = sql + ' AND '
        else:
            sql = 'WHERE '
        if(json[key].__class__ == unicode):
            sql = sql + key + " = \'" + json[key] + "\'"
        else:
            json[key] = json_module.dumps(json[key], ensure_ascii=False).replace('[', '(').replace(']', ')')
            string_concat = [sql, key ," in "]
            sql = ' '.join(string_concat) + json[key]
    try:
        mycursor.execute("SELECT l.id, l.nome_completo as nome, inst.nome_pais, inst.sigla_pais, curf.nome AS curso_faculdade, curf.centro_faculdade_id, coord.latitude, coord.longitude,  g.nome_instituicao, g.nome_curso as curso,g.ano_conclusao as ano, g.ano_inicio, g.status_curso FROM mestrados g LEFT JOIN lattes l ON (l.id = g.lattes_id)  LEFT JOIN cursos_faculdade curf ON (curf.id = l.curso_faculdade_id)LEFT JOIN instituicoes inst ON (inst.id = g.codigo_instituicao) LEFT JOIN coordenadas coord ON (coord.nome = g.nome_instituicao) %s" %sql )
    except Exception:
        return None
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

def teacher_business_master(json):
    sql = ''
    for key in json:
        if(sql != ''):
            sql = sql + ' AND '
        else:
            sql = 'WHERE '
        if(json[key].__class__ == unicode):
            sql = sql + key + " = \'" + json[key] + "\'"
        else:
            json[key] = json_module.dumps(json[key], ensure_ascii=False).replace('[', '(').replace(']', ')')
            string_concat = [sql, key ," in "]
            sql = ' '.join(string_concat) + json[key]
    try:
        mycursor.execute("SELECT l.id, l.nome_completo as nome, inst.nome_pais, inst.sigla_pais, curf.nome AS curso_faculdade, curf.centro_faculdade_id, coord.latitude, coord.longitude,  g.nome_instituicao, g.nome_curso as curso,g.ano_conclusao as ano, g.ano_inicio, g.status_curso FROM mestrados_profissionalizantes g LEFT JOIN lattes l ON (l.id = g.lattes_id)  LEFT JOIN cursos_faculdade curf ON (curf.id = l.curso_faculdade_id)LEFT JOIN instituicoes inst ON (inst.id = g.codigo_instituicao) LEFT JOIN coordenadas coord ON (coord.nome = g.nome_instituicao) %s" %sql )
    except Exception:
        return None
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

def teacher_doutorados(json):
    sql = ''
    for key in json:
        if(sql != ''):
            sql = sql + ' AND '
        else:
            sql = 'WHERE '
        if(json[key].__class__ == unicode):
            sql = sql + key + " = \'" + json[key] + "\'"
        else:
            json[key] = json_module.dumps(json[key], ensure_ascii=False).replace('[', '(').replace(']', ')')
            string_concat = [sql, key ," in "]
            sql = ' '.join(string_concat) + json[key]
    try:
        mycursor.execute("SELECT l.id, l.nome_completo as nome, inst.nome_pais, inst.sigla_pais, curf.nome AS curso_faculdade, curf.centro_faculdade_id, coord.latitude, coord.longitude,  g.nome_instituicao, g.nome_curso as curso,g.ano_conclusao as ano, g.ano_inicio, g.status_curso FROM doutorados g LEFT JOIN lattes l ON (l.id = g.lattes_id)  LEFT JOIN cursos_faculdade curf ON (curf.id = l.curso_faculdade_id)LEFT JOIN instituicoes inst ON (inst.id = g.codigo_instituicao) LEFT JOIN coordenadas coord ON (coord.nome = g.nome_instituicao) %s" %sql )
    except Exception:
        return None
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

def teacher_medical_special(json):
    sql = ''
    for key in json:
        if(sql != ''):
            sql = sql + ' AND '
        else:
            sql = 'WHERE '
        if(json[key].__class__ == unicode):
            sql = sql + key + " = \'" + json[key] + "\'"
        else:
            json[key] = json_module.dumps(json[key], ensure_ascii=False).replace('[', '(').replace(']', ')')
            string_concat = [sql, key ," in "]
            sql = ' '.join(string_concat) + json[key]
    try:
        mycursor.execute("SELECT l.id, l.nome_completo as nome, inst.nome_pais, inst.sigla_pais, curf.nome AS curso_faculdade, curf.centro_faculdade_id, coord.latitude, coord.longitude,  g.nome_instituicao, g.titulo_residencia_medica as curso,g.ano_conclusao as ano, g.ano_inicio, g.status_curso FROM residencias_medicas g LEFT JOIN lattes l ON (l.id = g.lattes_id)  LEFT JOIN cursos_faculdade curf ON (curf.id = l.curso_faculdade_id)LEFT JOIN instituicoes inst ON (inst.id = g.codigo_instituicao) LEFT JOIN coordenadas coord ON (coord.nome = g.nome_instituicao) %s" %sql )
    except Exception:
        return None
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

def teacher_livre_docencia(json):
    sql = ''
    for key in json:
        if(sql != ''):
            sql = sql + ' AND '
        else:
            sql = 'WHERE '
        if(json[key].__class__ == unicode):
            sql = sql + key + " = \'" + json[key] + "\'"
        else:
            json[key] = json_module.dumps(json[key], ensure_ascii=False).replace('[', '(').replace(']', ')')
            string_concat = [sql, key ," in "]
            sql = ' '.join(string_concat) + json[key]
    try:
        mycursor.execute("SELECT l.id, l.nome_completo as nome, inst.nome_pais, inst.sigla_pais, curf.nome AS curso_faculdade, curf.centro_faculdade_id, coord.latitude, coord.longitude,  g.nome_instituicao, g.titulo_trabalho as curso,g.ano_obtencao_titulo as ano FROM livre_docencias g LEFT JOIN lattes l ON (l.id = g.lattes_id)  LEFT JOIN cursos_faculdade curf ON (curf.id = l.curso_faculdade_id)LEFT JOIN instituicoes inst ON (inst.id = g.codigo_instituicao) LEFT JOIN coordenadas coord ON (coord.nome = g.nome_instituicao) %s" %sql )
    except Exception:
        return None
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

def teacher_pos_doutorados(json):
    sql = ''
    for key in json:
        if(sql != ''):
            sql = sql + ' AND '
        else:
            sql = 'WHERE '
        if(json[key].__class__ == unicode):
            sql = sql + key + " = \'" + json[key] + "\'"
        else:
            json[key] = json_module.dumps(json[key], ensure_ascii=False).replace('[', '(').replace(']', ')')
            string_concat = [sql, key ," in "]
            sql = ' '.join(string_concat) + json[key]
    try:
        mycursor.execute("SELECT l.id, l.nome_completo as nome, inst.nome_pais, inst.sigla_pais, curf.nome AS curso_faculdade, curf.centro_faculdade_id, coord.latitude, coord.longitude,  g.nome_instituicao, g.nome_curso_ingles as curso,g.ano_conclusao as ano, g.ano_inicio, g.status_curso FROM pos_doutorados g LEFT JOIN lattes l ON (l.id = g.lattes_id)  LEFT JOIN cursos_faculdade curf ON (curf.id = l.curso_faculdade_id)LEFT JOIN instituicoes inst ON (inst.id = g.codigo_instituicao) LEFT JOIN coordenadas coord ON (coord.nome = g.nome_instituicao) %s" %sql )
    except Exception:
        return None
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

def get_all_doutorados_coordinates():
    mycursor.execute("SELECT DISTINCT d.nome_instituicao, c.nome, c.latitude, c.longitude FROM doutorados d LEFT JOIN coordenadas c ON (c.nome = d.nome_instituicao)")
    row_headers=[x[0] for x in mycursor.description] #this will extract row headers
    rv = mycursor.fetchall()
    json_response = {}
    json_data=[]
    json_response['count'] = len(rv)
    if(len(rv) == 0):
        json_response['results'] = json_data
        return json_response
    for result in rv:
        coordenadas = {}
        json = {}
        jsonRow = dict(zip(row_headers,result))
        coordenadas['nome'] = jsonRow['nome']
        coordenadas['latitude'] = jsonRow['latitude']
        coordenadas['longitude'] = jsonRow['longitude']
        json['nome_instituicao'] = jsonRow['nome_instituicao']
        json['coordenadas'] = coordenadas
        json_data.append(json)
    json_response['results'] = json_data
    return json_response

def get_all_pos_doutorados_coordinates():
    mycursor.execute("SELECT DISTINCT d.nome_instituicao, c.nome, c.latitude, c.longitude FROM pos_doutorados d LEFT JOIN coordenadas c ON (c.nome = d.nome_instituicao)")
    row_headers=[x[0] for x in mycursor.description] #this will extract row headers
    rv = mycursor.fetchall()
    json_response = {}
    json_data=[]
    json_response['count'] = len(rv)
    if(len(rv) == 0):
        json_response['results'] = json_data
        return json_response
    for result in rv:
        coordenadas = {}
        json = {}
        jsonRow = dict(zip(row_headers,result))
        coordenadas['nome'] = jsonRow['nome']
        coordenadas['latitude'] = jsonRow['latitude']
        coordenadas['longitude'] = jsonRow['longitude']
        json['nome_instituicao'] = jsonRow['nome_instituicao']
        json['coordenadas'] = coordenadas
        json_data.append(json)
    json_response['results'] = json_data
    return json_response 
    
def get_formation_country_statistics(formation):
    mycursor.execute("SELECT nome_pais, COUNT(nome_pais) AS quantidade FROM %s g LEFT JOIN lattes l ON (l.id = g.lattes_id) LEFT JOIN instituicoes inst ON (inst.id = g.codigo_instituicao) WHERE nome_pais IS NOT NULL GROUP BY nome_pais ORDER BY nome_pais" %formation)
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

def get_formation_university_status(json, formation):
    sql = ''
    for key in json:
        if(sql != ''):
            sql = sql + ' AND '
        else:
            sql = 'WHERE '
        if(json[key].__class__ == unicode):
            sql = sql + key + " = \'" + json[key] + "\'"
        else:
            json[key] = json_module.dumps(json[key], ensure_ascii=False).replace('[', '(').replace(']', ')')
            string_concat = [sql, key ," in "]
            sql = ' '.join(string_concat) + json[key]
    try:
        mycursor.execute("SELECT status_curso, COUNT(status_curso) AS quantidade FROM %s g LEFT JOIN lattes l ON (l.id = g.lattes_id) LEFT JOIN instituicoes inst ON (inst.id = g.codigo_instituicao) %s GROUP BY status_curso ORDER BY status_curso" %(formation, sql))
    except Exception:
        return None
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

def get_formation_university_top_10(json, formation):
    sql = ''
    for key in json:
        if(sql != ''):
            sql = sql + ' AND '
        else:
            sql = 'WHERE '
        if(json[key].__class__ == unicode):
            sql = sql + key + " = \'" + json[key] + "\'"
        else:
            json[key] = json_module.dumps(json[key], ensure_ascii=False).replace('[', '(').replace(']', ')')
            string_concat = [sql, key ," in "]
            sql = ' '.join(string_concat) + json[key]
    try:
        mycursor.execute("SELECT nome_instituicao as instituicao, COUNT(nome_instituicao) AS quantidade FROM %s g LEFT JOIN lattes l ON (l.id = g.lattes_id) LEFT JOIN instituicoes inst ON (inst.id = g.codigo_instituicao) %s GROUP BY nome_instituicao ORDER BY quantidade DESC LIMIT 10" %(formation, sql))
    except Exception:
        return None
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