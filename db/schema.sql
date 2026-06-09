

CREATE TABLE IF NOT EXISTS users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL,
    email TEXT UNIQUE NOT NULL,
    password_hash TEXT NOT NULL,
    role TEXT NOT NULL DEFAULT 'member', 
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS members (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    user_id INTEGER NULL,
    name TEXT NOT NULL,
    email TEXT NULL,
    role_title TEXT NOT NULL, 
    bio TEXT NULL,
    image_path TEXT NULL,
    status TEXT NOT NULL DEFAULT 'active', 
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
);

CREATE TABLE IF NOT EXISTS events (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    title TEXT NOT NULL,
    description TEXT NOT NULL,
    category TEXT NOT NULL, 
    event_date DATE NOT NULL,
    event_time TEXT NOT NULL, 
    venue TEXT NOT NULL,
    image_path TEXT NULL,
    registration_link TEXT NULL,
    status TEXT NOT NULL DEFAULT 'upcoming', 
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS debates (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    title TEXT NOT NULL,
    description TEXT NULL,
    debate_type TEXT NOT NULL, 
    motion TEXT NOT NULL,
    video_url TEXT NULL, 
    debate_date DATE NULL,
    category TEXT NOT NULL DEFAULT 'English', 
    participants TEXT NULL, 
    outcome TEXT NULL, 
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS gallery (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    title TEXT NOT NULL,
    caption TEXT NULL,
    file_path TEXT NOT NULL,
    category TEXT NOT NULL, 
    upload_date DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS achievements (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    title TEXT NOT NULL, 
    competition TEXT NOT NULL, 
    year INTEGER NOT NULL,
    team_members TEXT NOT NULL, 
    description TEXT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS recruitment (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL,
    email TEXT NOT NULL,
    phone TEXT NOT NULL,
    roll_no TEXT NOT NULL,
    department TEXT NOT NULL,
    academic_year TEXT NOT NULL, 
    debating_experience TEXT NULL, 
    motivation TEXT NOT NULL, 
    status TEXT NOT NULL DEFAULT 'pending', 
    applied_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS contacts (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL,
    email TEXT NOT NULL,
    subject TEXT NOT NULL,
    message TEXT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE INDEX IF NOT EXISTS idx_users_email ON users(email);
CREATE INDEX IF NOT EXISTS idx_members_status ON members(status);
CREATE INDEX IF NOT EXISTS idx_events_date ON events(event_date);
CREATE INDEX IF NOT EXISTS idx_debates_date ON debates(debate_date);
CREATE INDEX IF NOT EXISTS idx_recruitment_status ON recruitment(status);
CREATE INDEX IF NOT EXISTS idx_contacts_email ON contacts(email);
