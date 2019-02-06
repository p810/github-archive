# Umi is a simple IRC client

class Flags:

  def __init__(self):
    self.flags = {}

  def has(self, key):
    if key not in self.flags:
      return False

    return True

  def set(self, key, value):
    self.flags[key] = value

  def get(self, key):
    if self.has(key) is False:
      return None
    
    return self.flags[key]

  def forget(self, key):
    if not self.has(key):
      return False
    else:
      self.flags.pop(key, None)

    return True