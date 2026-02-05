CREATE TYPE user_role AS ENUM ('admin', 'distributor','cliente');
CREATE TYPE user_status AS ENUM ('pending', 'approved', 'rejected', 'active');
CREATE TYPE invoice_type AS ENUM ('initial', 'regular');
CREATE TYPE invoice_status AS ENUM ('pending', 'paid', 'cancelled');
CREATE TYPE approval_action AS ENUM ('approved', 'rejected');



CREATE TABLE country(
  cod_country    char(3) NOT NULL,
  nombre      varchar(50),
  active boolean,
  CONSTRAINT country_pkey PRIMARY KEY (cod_country)
)WITH ( OIDS=FALSE );
ALTER TABLE country OWNER TO diana;

CREATE TABLE usuario (
    id SERIAL PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    lastname VARCHAR(100) NOT NULL,
    email VARCHAR(150) UNIQUE NOT NULL,
    username VARCHAR(150) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(50),
    identification VARCHAR(50) UNIQUE,

    cod_country    char(3) NOT NULL REFERENCES country(cod_country),

    usercode VARCHAR(20) UNIQUE NOT NULL,
    parent_id INTEGER NULL,

    role user_role NOT NULL DEFAULT 'cliente',
    status user_status NOT NULL DEFAULT 'pending',

    active smallint DEFAULT 0,
    active_desc text,
    
    auth_key         character varying(40),
    access_token     character varying(40),
  
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    user_updated INTEGER,

    CONSTRAINT fk_user_parent
        FOREIGN KEY (parent_id)
        REFERENCES usuario(id)
        ON DELETE SET NULL
);


CREATE TABLE product (
    id SERIAL PRIMARY KEY,
    image     character varying(177),
    name VARCHAR(150) NOT NULL,
    description TEXT,
    price NUMERIC(10,2) NOT NULL,
    is_initial_kit BOOLEAN,
    active BOOLEAN,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


CREATE TABLE invoice (
    id SERIAL PRIMARY KEY,
    user_id INTEGER NOT NULL,
    total NUMERIC(10,2) NOT NULL,
    type invoice_type NOT NULL,
    status invoice_status NOT NULL DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_invoice_user
        FOREIGN KEY (user_id)
        REFERENCES usuario(id)
        ON DELETE CASCADE
);

CREATE TABLE invoice_item (
    id SERIAL PRIMARY KEY,
    invoice_id INTEGER NOT NULL,
    product_id INTEGER NOT NULL,
    quantity INTEGER NOT NULL CHECK (quantity > 0),
    price NUMERIC(10,2) NOT NULL,

    CONSTRAINT fk_item_invoice
        FOREIGN KEY (invoice_id)
        REFERENCES invoice(id)
        ON DELETE CASCADE,

    CONSTRAINT fk_item_product
        FOREIGN KEY (product_id)
        REFERENCES product(id)
);


CREATE TABLE approval_log (
    id SERIAL PRIMARY KEY,
    user_id INTEGER NOT NULL,
    admin_id INTEGER NOT NULL,
    action approval_action NOT NULL,
    comment TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_log_user
        FOREIGN KEY (user_id)
        REFERENCES usuario(id),

    CONSTRAINT fk_log_admin
        FOREIGN KEY (admin_id)
        REFERENCES usuario(id)
);

CREATE INDEX idx_usuario_parent_id ON usuario(parent_id);
CREATE INDEX idx_invoice_user_id ON invoice(user_id);
CREATE UNIQUE INDEX idx_usuario_usercode ON usuario(usercode);

CREATE OR REPLACE FUNCTION update_timestamp()
RETURNS TRIGGER AS $$
BEGIN
   NEW.updated_at = CURRENT_TIMESTAMP;
   RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER trg_usuario_updated
BEFORE UPDATE ON usuario
FOR EACH ROW
EXECUTE FUNCTION update_timestamp();


INSERT INTO country(
            cod_country, nombre, active)
    VALUES
('76','Brazil', 'true'),
('170','Colombia', 'true'),
('218','Ecuador', 'true'),
('484','Mexico', 'true'),
('604','Peru', 'true');


INSERT INTO usuario( id, name, lastname, email, username, password,
  identification, cod_country, usercode, role, status, active)
VALUES (0, 'Diana', 'Florez', 'dianaflorezbravo@gmail.com', 'DianaFlorez', 'diwVJvPs7M..6', 
  '1085777', '170', '007','admin', 'active', 1);