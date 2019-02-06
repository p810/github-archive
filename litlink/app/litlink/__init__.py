import API

'''
A base controller which returns a lambda object of metadata pertaining to the page being rendered.
  
  @param title   string | Suffix of the <title> tag
  @param scripts list   | Additional Javascript dependencies to load
  @param styles  list   | Additional CSS dependencies to load
'''
def page_meta(title, scripts = None, styles = None):
  page = type('lamdbaobject', (object,), {})()

  page.title   = title
  page.scripts = scripts
  page.styles  = styles

  return page

'''
An instance of APIResponse to expose to the controllers.
'''
API = API.APIResponse()