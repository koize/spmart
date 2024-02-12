import mysql.connector
import time

time.sleep(3)
mydb = mysql.connector.connect(
  host="localhost",
  user="root",
  password="",
  database="spmart"
)

mycursor = mydb.cursor()

def fetch_product_name(sku):
    mycursor.execute("SELECT product_name FROM products WHERE product_sku = %s", (sku,))
    myresult = mycursor.fetchall()
    if myresult == []:
        mydb.commit()
        return "SKU not found"
    for x in myresult:
     x = x[0]
     print(x)
     mydb.commit()
     return x


def fetch_product_price(sku):
    mycursor.execute("SELECT product_price FROM products WHERE product_sku = %s", (sku,))
    myresult = mycursor.fetchall()
    if myresult == []:
        mydb.commit()
        return 0
    for x in myresult:
     x = x[0]
     print(x)
     mydb.commit()
     return x
