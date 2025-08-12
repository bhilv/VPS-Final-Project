# VPS Final Project – SVAD-116 (Linux Administration)

This repository contains the final project for **SVAD-116: Linux Administration**, showcasing the deployment, configuration, and security hardening of a **Virtual Private Server (VPS)**. The project focuses on secure service hosting, intrusion prevention, and automated log analysis, as well as a write-up to explain our choices and reasoning.


## Project Overview
The VPS runs on **Ubuntu Server** (no desktop environment) and is configured to provide secure, efficient, and reliable services, including:

- **HTTPS-secured website** using [Apache2](https://httpd.apache.org/) and [Certbot](https://certbot.eff.org/) for SSL/TLS certificate generation.
- **MySQL** database backend for dynamic content and secure data storage.
- **OpenSSH** for remote administration, configured with strong security controls.


## Security Implementation
Security was a central focus of this project, with the following measures implemented:

- **SSH Key Authentication** – Only authorized RSA keypairs are permitted; root login and password authentication are disabled.
- **Fail2Ban** – Actively monitors and blocks repeated failed login attempts to mitigate brute-force attacks.
- **Session-Based Access Control** – PHP-based authentication requiring valid user credentials for protected content.
- **Hashed Credentials** – User passwords are securely hashed before storage in MySQL.


## Web Application Details
- **PHP-MySQL Secure Content Platform** – Authenticated users can access protected content via properly managed PHP sessions.
- **phpMyAdmin** – Installed for streamlined database management.


## Automation & Monitoring
Custom shell scripts were developed to enhance ongoing server monitoring and security analysis:

- **Weekly Attack Reports** – Summarizes detected intrusion attempts.
- **Failed Login Tracking** – Identifies repeated SSH login failures.
- **IP Logging & Analysis** – Records and reviews IP addresses associated with suspicious activity.
- **HTTPS Attack Monitoring** – Parses server logs for malicious or suspicious web requests.


## Repository Structure
```plaintext
.
├── /scripts            # Custom security and monitoring scripts
├── /webpage-php        # Web application files (PHP, HTML)
├── Write up            # Reasoning behind the processes
└── README.md           # you are here :)
