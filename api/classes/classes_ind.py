#!/usr/bin/env python
# -*- coding: utf-8 -*-
from flask import Flask, request, render_template
from flask_restful import Resource, Api
from flask_cors import CORS
from ind import api_requests

class GetCenters(Resource):
    def get(self, count=None):
        response = api_requests.get_centers(count)
        return response

class GetCenterId(Resource):
    def post(self):
        response = api_requests.get_center_id(request.get_json())
        return response

class GetCentersSpecific(Resource):
    def get(self, id, count=None):
        response = api_requests.get_center_specific(id, count)
        return response

class GetTeachers(Resource):
    def get(self, count=None):
        response = api_requests.get_teachers(count)
        return response

class GetTeacherId(Resource):
    def post(self):
        response = api_requests.get_teacher_id(request.get_json())
        return response

class GetTeachersStatistics(Resource):
    def get(self, limit):
        response = api_requests.get_teacher_statistics(limit)
        return response

class GetTeachersDetails(Resource):
    def get(self, id):
        response = api_requests.get_teachers_details(id)
        return response

class GetTeachersFromCenter(Resource):
    def get(self, id, count=None):
        response = api_requests.get_teachers_from_center(id, count)
        return response

class GetUniversityCourses(Resource):
    def get(self, count=None):
        response = api_requests.get_university_courses(count)
        return response

class GetUniversityCoursesFromCenter(Resource):
    def get(self, id, count=None):
        response = api_requests.get_university_courses_from_center(id, count)
        return response

class GetPublishedArticles(Resource):
    def get(self, count=None):
        response = api_requests.get_published_articles(count)
        return response

class GetPublishedArticlesFromCenter(Resource):
    def get(self, id, count=None):
        response = api_requests.get_published_articles_from_center(id, count)
        return response

class GetPublishedArticlesFromCenterStatistics(Resource):
    def get(self, id):
        response = api_requests.get_published_articles_from_center_statistics(id)
        return response

class GetEventsWorks(Resource):
    def get(self, count=None):
        response = api_requests.get_events_works(count)
        return response

class GetEventsWorksFromCenter(Resource):
    def get(self, id, count=None):
        response = api_requests.get_events_works_from_center(id, count)
        return response
        
class GetPublishedCapBooks(Resource):
    def get(self, count=None):
        response = api_requests.get_published_cap_books(count)
        return response

class GetPublishedArticlesWithoutQualis(Resource):
    def get(self):
        response = api_requests.get_published_articles_without_qualis()
        return response

class GetPublishedCapBooksFromCenter(Resource):
    def get(self, id, count=None):
        response = api_requests.get_published_cap_books_from_center(id, count)
        return response

class GetArticleYear(Resource):
    def get(self):
        response = api_requests.get_articles_years()
        return response

class GetArticleYearFromCenter(Resource):
    def get(self, id):
        response = api_requests.get_articles_years_from_center(id)
        return response

class GetQualisStatistics(Resource):
    def get(self):
        response = api_requests.get_qualis_statistics()
        return response

class GetQualisStatisticsByRank(Resource):
    def get(self, rank):
        response = api_requests.get_qualis_statistics_by_rank(rank)
        return response

class GetQualisStatisticsByCenter(Resource):
    def get(self, id, year):
        response = api_requests.get_qualis_statistics_by_center(id, year)
        return response

class GetQualisStatisticsByYear(Resource):
    def get(self, year):
        response = api_requests.get_qualis_statistics_by_year(year)
        return response

class GetPublishStatisticsByYear(Resource):
    def get(self):
        response = api_requests.get_publish_statistics_by_year()
        return response
