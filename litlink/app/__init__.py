from flask import Flask

app = Flask(__name__)

# Controllers
from app import routes