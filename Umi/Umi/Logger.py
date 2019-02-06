# Umi is a simple IRC client

import sqlite3, sys, subprocess, datetime

class Logger:

  def __init__(self, conf):
    self.conf = conf

    if self.conf.log() is not None:
      sys.stdout = open('umi.log', 'w')

  def out(self, type, msg):
    print '[{0}] {1} ... {2}'.format(type.upper(), datetime.datetime.now(), msg)

  def notify(self, title, msg):
    subprocess.call(['osascript', '-e', 'display notification "{0}" with title "{1}"'.format(msg, title)])