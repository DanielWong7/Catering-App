# Catering App

## *Mission*
The current ordering process for catering service and the way any meaningful data is extracted from the log sheets is inefficient and cumbersome. 
 
For the Facilities Team to create a proper budget, plan for the upcoming year, and deliver catering services in a timely and efficient manner the burden of any solution would be to digitize the process and make extracting analytics automatic.

For that reason, the Toronto Dshop Team along with the Toronto Facilities Team have come together to create the SAP Catering App which truly digitizes the process of ordering a catering service and extracting meaningful data, all while keeping a strong focus in User Experience.

## *Summary*
The App aims to digitize the way SAP employees book catering services for their meetings, whether they are internal or external. By digitizing the process, the Facilities Team can gather various data more efficiently. Some examples of possible analytics which can be gained from the App include the popularity of a specific vendor, and the number of internal vs external meetings. All these benefits allow the Facilities Team to create a more cost-effective budget and plan more competently for the following year

## Quick Start
  * ### [Features](genius/ReleaseDoc1.docx)
  * ### [User Guide](genius/index%20(2).html)
# Setup
Install XAMPP from https://www.apachefriends.org/index.html.

Open up the folder where you installed XAMPP and go to htdocs.

Delete all the files preinstalled into htdocs.

Drag all of the files from the repository EXCEPT FOR THE .sql FILES into htdocs.

Run the XAMPP Control Panel/xampp-control.exe.

Press the Config button beside Apache and select httpd-xampp.conf.

Scroll down and find the <Directory "yourpath/phpMyAdmin"> and replace content with this.


	AllowOverride AuthConfig
	Order allow,deny
	Require local
	Allow from all
	ErrorDocument 403 /error/XAMPP_FORBIDDEN.html.var


(This will make the phpmyadmin page only accessible to the host).


Now press Start beside Apache and MySQL.

Open up a browser and go to http://localhost/phpmyadmin/ (If a login is prompt, the user should be 'root' with no password).

Go to the left navbar and press New.

Name the new database 'cateringapp' with collation utf8_general_ci.

Now you can drag the cateringapp.sql file into the database. You should see two tables, cateringdata and log.

Then do the exact same with the loginsystem.sql file.

If you now type in localhost in the address bar it should redirect you to localhost/login_page.php.

Username will be 'dshop' the password will be 'dshop123!'. This will redirect to the admin page where you can add/delete users. Logins from normal users will redirect to the form instead.
## *Acknowledgements*
This SAP Catering App was made possible because of the hard work and hours put in by two groups of high school interns and their supervisor. Under supervision and guidance by Luis Sanroman Zugasti, the first group of high school interns: Talha Shaikh and Xiang Weng created the framework for the Catering Application. They worked extremely hard to push out a working copy of the App and by the end of their term at SAP they managed to do that. By creating that framework, the next group of interns: Danial Wong and Muhammad Hamza Mahboob, worked hard to complete enhancement requests and push out a copy of the SAP Catering App, which met the needs of the SAP Facilities Team. However, none of this could be done without the guidance of Luis and the resources available in the Dshop.  

<img src="genius/images/sap.png" width ="150" ><img src="genius/images/dshop-logo-small.png" width="150" >
