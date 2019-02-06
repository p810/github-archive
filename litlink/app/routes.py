from app import app
from app.litlink import API, page_meta
from flask import render_template, jsonify, request

'''
The site's index page.
'''
@app.route('/')
def index():
  page = page_meta(title = 'Home', scripts = ['litlink.js'])

  return render_template(
    'index.html',
    page  = page
  )

'''
Takes a link provided in the POST body of the request and returns a URL for it.
'''
@app.route('/shorten', methods = ['POST'])
def shorten():
  if not request.form['link']:
    response, status = API.error(1)
  else:
    response, status = {'url' : 'Hello world'}, 200

  return jsonify(response), status