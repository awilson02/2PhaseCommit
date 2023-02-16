# 2phaseCommit

Author: Alexander Wilson

--Description 
This project contains 3 websites. CompanyX and CompanyY which sell parts. The have front end and use php to 
query their MySQL dbs. CompanyZ has its on db but uses its REST services to contact both X and Y allowing 
a user to purchase from both. The db code is in companyZ/db in that file each company's table are in one DB, 
but they can be separated. Then seed file for the db is also in companyZ.This also implemenets 2PC through sending urls.  
