import os, shutil
import hashlib
import json
import glob
from pprint import pprint

def loadSessionDir(name_dir):
   dir = os.path.dirname(name_dir)
   try: 
      os.makedirs(dir)
   except OSError:
      if not os.path.isdir(dir):
         raise

def createSession(path,name,text):
   fh = open(path+'sess_'+hashlib.md5(name.encode()).hexdigest(), "w")
   fh.write(text)
   fh.close()

def destroySession(name):
   print(name)

def destroySessions(dirpath):
   for filename in os.listdir(dirpath):
        filepath = os.path.join(dirpath, filename)
        try:
            shutil.rmtree(filepath)
        except OSError:
            os.remove(filepath)

def getSession(path,table):
   for name in os.listdir(path):
      with open(path+name) as data_file:    
         data = json.load(data_file)
         return data[table]

def ifSessionExist(directory):
   if not os.listdir(directory):
      return False
   else:
      return True
