class APIResponse:
  
  # Error messages to return to the client via the API.
  errors = {
    1 : {
      'message' : 'No URL was provided',
      'status'  : 400
    }
  }

  '''
  These values represent the total number of alphanumeric combinations possible (value)
  for each character limit (key). These values are used to determine when to raise the 
  number of characters used for new URIs.
  '''
  ranges = [
    0: None, 
    1: 62, 
    2: 3844, 
    3: 238328,
    4: 14776336
  ]

  '''
  Sends an error to the client via the API. A tuple containing the payload and HTTP status
  of the request is returned.

    @param id      int    default 0    | The key by which to look up in self.errors
    @param message string default None | Optional message, if the ID is not found.
    @param http    int    default None | Optional HTTP status, if the ID is not found.
  '''
  def error(self, id = 0, message = None, http = None):
    if id not in self.errors:
      if message is None or http is None:
        return ({'error' : 'An unexpected error occurred', 'code' : 0}, 500)
      else:
        return ({'error' : message, 'code' : id}, http)
    else:
      return ({'error' : self.errors[id]['message'], 'code' : id}, self.errors[id]['status']) 