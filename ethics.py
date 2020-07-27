import psycopg2
from googlesearch import search 
from datetime import datetime
import sys, getopt


now = datetime.now();

pid=sys.argv[1];
name=sys.argv[2];

def main(pid,name):
  keywords=['corruption','bribery','competition','anti-trust','fraud','criminal proceeding','government','minister']

  results=[];
  try:
    for x in keywords:
      query = name + ' ' + x
      for j in search(query, tld="com", num=10, stop=10, pause=2):
        results.append((pid,query,j,now))
  except:
    print("error")
    sys.exit(0)
  try:
    sdb = psycopg2.connect(database="bppv2", user = "postgres", password = "appu123", host = "127.0.0.1", port = "5432")

    mycursor = sdb.cursor()
    sql = "DELETE FROM searches WHERE partner_id = '"+str(pid)+"'"
    mycursor.execute(sql)
    sdb.commit()

    sql = "INSERT INTO searches (partner_id,criteria,links,created_at) VALUES (%s, %s,%s,%s)"
    mycursor.executemany(sql, results)
    sdb.commit()

  except:
    print("DB error")
    sys.exit(0)


if __name__ == "__main__":
  main(pid,name)