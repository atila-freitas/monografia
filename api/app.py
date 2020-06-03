#!/usr/bin/env python
# -*- coding: utf-8 -*-
from flask import Flask, request, render_template
from flask_restful import Resource, Api
from flask_cors import CORS
from ind import api_requests
from gis import gis_requests
from classes.classes_ind import *
import sys

app = Flask(__name__)
cors = CORS(app, resources={r"/*": {"origins": "*"}})
api = Api(app)



class GetPaises(Resource):
    def post(self):
        response = gis_requests.get_paises(request.get_json())
        return response

class GetTeachersFormationStatistics(Resource):
    def get(self):
        response = gis_requests.teachers_formation_statistics()
        return response

class GetTeachersFormationCountryStatistics(Resource):
    def get(self, formation):
        response = gis_requests.get_formation_country_statistics(formation)
        return response

class GetTeachersFormationUniversityStatus(Resource):
    def post(self, formation):
        response = gis_requests.get_formation_university_status(request.get_json(), formation)
        return response

class GetTeachersFormationUniversityTop10(Resource):
    def post(self, formation):
        response = gis_requests.get_formation_university_top_10(request.get_json(), formation)
        return response

class GetTeachersFormationGraduate(Resource):
    def post(self):
        response = gis_requests.teacher_graduation(request.get_json())
        return response

class GetTeachersFormationAperfeicoa(Resource):
    def post(self):
        response = gis_requests.teacher_aperfeicoa(request.get_json())
        return response

class GetTeachersFormationEspecializa(Resource):
    def post(self):
        response = gis_requests.teacher_especializa(request.get_json())
        return response

class GetTeachersFormationMaster(Resource):
    def post(self):
        response = gis_requests.teacher_master(request.get_json())
        return response

class GetTeachersFormationBusinessMaster(Resource):
    def post(self):
        response = gis_requests.teacher_business_master(request.get_json())
        return response

class GetTeachersFormationDoutorado(Resource):
    def post(self):
        response = gis_requests.teacher_doutorados(request.get_json())
        return response

class GetTeachersFormationMedicalSpecial(Resource):
    def post(self):
        response = gis_requests.teacher_medical_special(request.get_json())
        return response

class GetTeachersFormationLivreDocencia(Resource):
    def post(self):
        response = gis_requests.teacher_livre_docencia(request.get_json())
        return response

class GetTeachersFormationPosDoutorado(Resource):
    def post(self):
        response = gis_requests.teacher_pos_doutorados(request.get_json())
        return response

class GetAllDoutoradoCoordinates(Resource):
    def get(self):
        response = gis_requests.get_all_doutorados_coordinates()
        return response

class GetAllPosDoutoradoCoordinates(Resource):
    def get(self):
        response = gis_requests.get_all_pos_doutorados_coordinates()
        return response


#Requests to Siq System

api.add_resource(GetPaises, '/gis/paises')
api.add_resource(GetTeachersFormationStatistics, '/gis/teachersFormationStatistics')
api.add_resource(GetTeachersFormationCountryStatistics, '/gis/teachersFormationCountryStatistics/<formation>')
api.add_resource(GetTeachersFormationUniversityStatus, '/gis/teachersFormationUniversityStatus/<formation>')
api.add_resource(GetTeachersFormationUniversityTop10, '/gis/teachersFormationUniversityTop10/<formation>')
api.add_resource(GetTeachersFormationGraduate, '/gis/teachersFormationGraduate')
api.add_resource(GetTeachersFormationAperfeicoa, '/gis/teachersFormationAperfeicoa')
api.add_resource(GetTeachersFormationEspecializa, '/gis/teachersFormationEspecializa')
api.add_resource(GetTeachersFormationMaster, '/gis/teachersFormationMaster')
api.add_resource(GetTeachersFormationBusinessMaster, '/gis/teachersFormationBusinessMaster')
api.add_resource(GetTeachersFormationDoutorado, '/gis/teachersFormationDoutorado')
api.add_resource(GetTeachersFormationMedicalSpecial, '/gis/teachersFormationMedicalSpecial')
api.add_resource(GetTeachersFormationLivreDocencia, '/gis/teachersFormationLivreDocencia')
api.add_resource(GetTeachersFormationPosDoutorado, '/gis/teachersFormationPosDoutorado')
api.add_resource(GetAllDoutoradoCoordinates, '/gis/allDoutoradoCoordinates')
api.add_resource(GetAllPosDoutoradoCoordinates, '/gis/allPosDoutoradoCoordinates')

#Requests to Ind System
api.add_resource(GetCenters, '/ind/centers/<count>', '/ind/centers')
api.add_resource(GetCenterId, '/ind/centerId')
api.add_resource(GetCentersSpecific, '/ind/centersSpecific/<id>/<count>', '/ind/centersSpecific/<id>')
api.add_resource(GetTeachers, '/ind/teachers/<count>',  '/ind/teachers')
api.add_resource(GetTeacherId, '/ind/teacherId')
api.add_resource(GetTeachersStatistics, '/ind/teacherStatistics/<limit>')
api.add_resource(GetTeachersDetails, '/ind/teacherDetail/<id>')
api.add_resource(GetTeachersFromCenter, '/ind/teachersFromCenter/<id>/<count>', '/ind/teachersFromCenter/<id>')
api.add_resource(GetUniversityCourses, '/ind/universityCourses/<count>',  '/ind/universityCourses')
api.add_resource(GetUniversityCoursesFromCenter, '/ind/universityCoursesFromCenter/<id>/<count>', '/ind/universityCoursesFromCenter/<id>')
api.add_resource(GetPublishedArticles, '/ind/publishedArticles/<count>', '/ind/publishedArticles')
api.add_resource(GetPublishedArticlesWithoutQualis, '/ind/publishedArticlesWithoutQualis')
api.add_resource(GetPublishedArticlesFromCenter, '/ind/publishedArticlesFromCenter/<id>/<count>','/ind/publishedArticlesFromCenter/<id>')
api.add_resource(GetPublishedArticlesFromCenterStatistics, '/ind/publishedArticlesFromCenterStatistics/<id>')
api.add_resource(GetEventsWorks, '/ind/eventsWorks/<count>', '/ind/eventsWorks')
api.add_resource(GetEventsWorksFromCenter, '/ind/eventsWorksFromCenter/<id>/<count>', '/ind/eventsWorksFromCenter/<id>')
api.add_resource(GetPublishedCapBooks, '/ind/publishedCapBooks/<count>', '/ind/publishedCapBooks')
api.add_resource(GetPublishedCapBooksFromCenter, '/ind/publishedCapBooksFromCenter/<id>/<count>', '/ind/publishedCapBooksFromCenter/<id>')
api.add_resource(GetArticleYear, '/ind/articleYear')
api.add_resource(GetArticleYearFromCenter, '/ind/articleYear/<id>')
api.add_resource(GetQualisStatistics, '/ind/qualisStatistics')
api.add_resource(GetQualisStatisticsByRank, '/ind/qualisStatisticsByRank/<rank>')
api.add_resource(GetQualisStatisticsByCenter, '/ind/qualisStatisticsByCenter/<id>/<year>')
api.add_resource(GetQualisStatisticsByYear, '/ind/qualisStatisticsByYear/<year>')
api.add_resource(GetPublishStatisticsByYear, '/ind/publishStatisticsByYear')



if __name__ == '__main__':
    app.run(host="0.0.0.0", debug=True, threaded=True, port=9000)