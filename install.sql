CREATE TABLE IF NOT EXISTS miscapps ( 
	miscapps_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY , 
	ext VARCHAR( 50 ) , 
	description VARCHAR( 50 ) , 
	dest VARCHAR( 255 ) 
);
