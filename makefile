test:
	echo "no tests yet"

serve:
	php -S localhost:5000
getusers:
	echo "SELECT * FROM users" | mysql -u root -p userdata 
getposts:
	echo "SELECT * FROM posts" | mysql -u root -p userdata 