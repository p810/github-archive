# Umi is a simple IRC client

class Message:

  def parse(self, incoming):
    # Reset the tokens we're handling on a case by case basis
    self.tokens = incoming.split(' ')

    # Sanitize the tokens
    self.sanitize()

    return self.tokens

  def sanitize(self):
    for key, token in enumerate(self.tokens):
      if token.startswith(':'):
        self.tokens[key] = token.strip(':')

      self.tokens[key].strip('\r\n')

    return self.tokens

  def user(self):
    split = self.tokens[0].strip(':').split('!')

    if len(split) > 1:
      return split
    else:
      return None

  def channel(self):
    if self.tokens[2].startswith('#'):
      return self.tokens[2]
    else:
      return None 