test:
	echo "no tests yet"

serve:
	php -S localhost:5000
getdb:
	echo "SELECT * FROM users" | mysql -u root -p userdata 
sqlTableToTxt:
	echo "SELECT * FROM users" | mysql -u root -p userdata >> a.txt