import mysql.connector

mydb = mysql.connector.connect(
  host="mysql",
  user="root",
  password="",
  database="spmart"
)

mycursor = mydb.cursor()

def fetch_product_name(sku):
    mycursor.execute("SELECT product_name FROM products WHERE product_sku = %s", (sku,))
    myresult = mycursor.fetchall()
    if myresult == []:
        return "SKU not found"
    for x in myresult:
     print(x)
     return x


def fetch_product_price(sku):
    mycursor.execute("SELECT product_price FROM products WHERE product_sku = %s", (sku,))
    myresult = mycursor.fetchall()
    if myresult == []:
        return ""
    for x in myresult:
     print(x)
     return x
