
        
        CREATE TABLE admin (
            admin_id INT PRIMARY KEY AUTO_INCREMENT,
            admin_username VARCHAR(255) NOT NULL,
            admin_password VARCHAR(255) NOT NULL,
            admin_email VARCHAR(255) NOT NULL
        );

        CREATE TABLE clients (
            client_id BIGINT PRIMARY KEY AUTO_INCREMENT,
            first_name VARCHAR(255) NOT NULL,
            last_name VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL,
            phone_number VARCHAR(15),
            address VARCHAR(255),
            client_password VARCHAR(255) NOT NULL
        );
        
        CREATE TABLE photo_sessions (
            session_id BIGINT PRIMARY KEY AUTO_INCREMENT,
            client_id BIGINT NOT NULL,
            session_type VARCHAR(255),
            session_date DATE,
            location VARCHAR(255),
            status VARCHAR(50),
            FOREIGN KEY (client_id) REFERENCES clients(client_id)
        );

        CREATE TABLE photos (
            photo_id BIGINT PRIMARY KEY AUTO_INCREMENT,
            session_id BIGINT NOT NULL,
            photo longblob NOT Null,
            private BOOLEAN,
            date DATE,
            name VARCHAR(255),
            FOREIGN KEY (session_id) REFERENCES photo_sessions(session_id)
        );

        CREATE TABLE appointments (
            appointment_id BIGINT PRIMARY KEY AUTO_INCREMENT,
            client_id BIGINT NOT NULL,
            appointment_date DATE,
            appointment_time TIME,
            status VARCHAR(50),
            FOREIGN KEY (client_id) REFERENCES clients(client_id)
        );

        CREATE TABLE packages (
            package_id BIGINT PRIMARY KEY AUTO_INCREMENT,
            package_name VARCHAR(255) NOT NULL,
            description VARCHAR(255),
            price DECIMAL(10, 2) NOT NULL
        );

        CREATE TABLE orders (
            order_id BIGINT PRIMARY KEY AUTO_INCREMENT,
            client_id BIGINT NOT NULL,
            session_id BIGINT,
            package_id BIGINT,
            order_date DATE,
            total_amount DECIMAL(10, 2),
            status VARCHAR(50),
            FOREIGN KEY (client_id) REFERENCES clients(client_id),
            FOREIGN KEY (session_id) REFERENCES photo_sessions(session_id),
            FOREIGN KEY (package_id) REFERENCES packages(package_id)
        );

