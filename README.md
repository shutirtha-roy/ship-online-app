# Ship Online Project

Author: Shutirtha Roy  

## Code Instructions

The project structure is as follows:
- `public` folder: Contains static files like CSS
- `src` folder: Contains all code files
  - `src/configuration/connection/connect.php`: Database connection
  - `src/pages/`: Main pages of the application
  - `src/service/`: Business logic
  - `src/helpers/`: Validation logic
  - `src/repository/`: Database queries
  - `src/configuration/constants/`: Constant values

## Web Application Instructions

1. Browse to the application URL
2. On the home page, users can Login, Register, or view the admin page
3. Clicking "Get Started" takes you to the Login Page
4. The Register page allows new users to sign up
5. After registration, users see a Dashboard with their unique customer ID
6. Logged-in users can request shipments
7. Admin page is accessible only when logged out

## File Structure

1. `public/css/`
   - admin.css
   - home-ship-online.css
   - login.css
   - pre-request.shipment.css
   - register.css
   - request-shipment.css

2. `src/configuration/`
   - connection/connect.php
   - constants/account-service-contants.php
   - constants/database-constants.php
   - constants/database-server-constants.php
   - constants/request-service-contants.php

3. `src/helpers/`
   - account_validation.php
   - request_validation.php

4. `src/pages/`
   - account/login.php
   - account/logout.php
   - account/register.php
   - admin/admin.php
   - common/nav.php
   - home/shiponline.php
   - request_shipment/pre-request-shipment.php
   - request_shipment/request-shipment.php

5. `src/repository/`
   - account_repository.php
   - admin_repository.php
   - repository.php
   - request_repository.php

6. `src/service/`
   - account_service.php
   - admin_service.php
   - request_service.php
