# Umi is a simple IRC client

import socket, select, time, threading
import Message, Logic

class IRC:

  def __init__(self, addr, log, conf):
    # Store the logger
    self.log = log

    # ... and a configuration object
    self.config  = conf
    self.options = conf.all()

    # Create a socket resource
    self.pipe = socket.socket(socket.AF_INET, socket.SOCK_STREAM)

    # We don't want this socket to timeout
    self.pipe.settimeout(None)
    
    # Set up channels for socket interaction
    self.incoming   = [ self.pipe ]

    self.output     = []
    self.outgoing   = []

    self.exceptions = [ self.pipe ]

    # And an instance of Message, which will handle sanitization
    self.msg = Message.Message()

    # An instance of Logic, which will control outgoing messages and respond to events
    self.logic = Logic.Logic(self.output, self.msg, self.log)

    self.log.out('info', 'Socket resource opened [{0}]'.format(self.pipe.fileno()))
    
    # Connect to the IRC network
    try:
      self.pipe.connect(addr)

      self.pipe.setblocking(0)

      self.logic.greet(self.config.identity())
    except:
      self.log.out('warn', 'Failed to connect to the network')
      
      exit()

    self.log.out('info', 'Connected to {0}:{1} successfully [{2}]'.format(addr[0], addr[1], self.pipe.fileno()))

  def run(self):
    while self.incoming:
      read, write, exception = select.select(self.incoming, self.outgoing, self.exceptions, 0)

      if self.pipe in read:
        incoming = self.pipe.recv(612)

        if incoming:
          if self.options['dev']['out'] is True:
            print incoming

          tokens  = self.msg.parse(incoming)

          trigger = self.trigger(tokens)

          if trigger is not False:
            self.handle(tokens, trigger)

            if len(self.output) > 0: 
              self.outgoing.append( self.pipe )
        
        elif not incoming:
          break

      elif self.pipe in write:
        for key, msg in enumerate(self.output):
          
          try:
            self.pipe.send(msg + '\r\n')

            self.output.remove(self.output[key])
          except:
            raise
      
      elif self.pipe in exception:
        self.log.out('warn', 'The bot encountered an error and needed to shut down')

        break

      time.sleep(0.1)

    self.close()

  def close(self):
    del self.incoming

    self.pipe.close()

    self.log.out('info', 'Closing connection with the network')

  def handle(self, tokens, trigger):
    index = tokens[trigger].lower()

    if isinstance(self.logic.handlers[index], list):
      for key, value in enumerate(self.logic.handlers[index]):
        callback = getattr(self.logic, self.logic.handlers[index][key])

        callback(tokens)
    else:
      callback = getattr(self.logic, self.logic.handlers[index])

      callback(tokens)

  def trigger(self, tokens):
    for key, token in enumerate(tokens):
      if token.lower() in self.logic.handlers:
        return key

    return False