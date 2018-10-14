#!/usr/bin/python
import MySQLdb
import matplotlib.pyplot as plt
plt.switch_backend('agg')
import numpy as np
import matplotlib.dates as mdates
from matplotlib.pyplot import figure
figure(num=None, figsize=(10, 1), dpi=100, facecolor='w', edgecolor='k')
import tempfile
import itertools as IT
import os
db = MySQLdb.connect(host="localhost",  # your host
                     user="user",       # username
                     passwd="pw",     # password
                     db="db")   # name of the database

# Create a Cursor object to execute queries.
cur = db.cursor()

# Select data from table using SQL query.
cur.execute("SELECT hour(whattime), COUNT(*) from irclog where whattime >= CURDATE() group by hour(whattime) order by hour(whattime);")

# print the first and second columns
elemek1 = list()
elemek2 = list()
for row in cur.fetchall() :
#    print row[0], " ", row[1]
    elemek1.append(row[0])
    elemek2.append(row[1])
#for i, v in enumerate(elemek1):
#    plt.text(v, i, " "+str(v), color='blue', va='center', fontweight='normal')


plt.bar(elemek1, elemek2, label='msg/hr')

plt.legend(loc='upper left')
plt.title('Today\'s statistics')
#plt.show()

x = elemek1
y = elemek2

#plt.savefig('/var/www/chart.png', bbox_inches='tight')
#os.chmod('/var/www/chart.png', 0o777)

plt.savefig('/mnt/ramdisk/chart.png', bbox_inches='tight')
os.chmod('/mnt/ramdisk/chart.png', 0o777)
