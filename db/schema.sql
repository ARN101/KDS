-- SQLite Schema for KUET Debating Society (KDS)

-- 1. Users Table (Authentication and Access Control)
CREATE TABLE IF NOT EXISTS users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL,
    email TEXT UNIQUE NOT NULL,
    password_hash TEXT NOT NULL,
    role TEXT NOT NULL DEFAULT 'member', -- 'admin', 'member'
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- 2. Members Table (Public profile information)
CREATE TABLE IF NOT EXISTS members (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    user_id INTEGER NULL,
    name TEXT NOT NULL,
    email TEXT NULL,
    role_title TEXT NOT NULL, -- e.g., 'President', 'General Secretary', 'Senior Debater'
    bio TEXT NULL,
    image_path TEXT NULL,
    status TEXT NOT NULL DEFAULT 'active', -- 'active', 'alumni'
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
);

-- 3. Events Table
CREATE TABLE IF NOT EXISTS events (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    title TEXT NOT NULL,
    description TEXT NOT NULL,
    category TEXT NOT NULL, -- 'Bangla Debate', 'English Debate', 'Workshop', 'Tournament'
    event_date DATE NOT NULL,
    event_time TEXT NOT NULL, -- e.g., '15:30'
    venue TEXT NOT NULL,
    image_path TEXT NULL,
    registration_link TEXT NULL,
    status TEXT NOT NULL DEFAULT 'upcoming', -- 'upcoming', 'ongoing', 'past'
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- 4. Debates Table (Featured debates with video embeds)
CREATE TABLE IF NOT EXISTS debates (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    title TEXT NOT NULL,
    description TEXT NULL,
    debate_type TEXT NOT NULL, -- 'British Parliamentary', 'Asian Parliamentary', 'Traditional'
    motion TEXT NOT NULL,
    video_url TEXT NULL, -- YouTube video ID or full embed link
    debate_date DATE NULL,
    category TEXT NOT NULL DEFAULT 'English', -- 'Bangla', 'English'
    participants TEXT NULL, -- Names of key participants (e.g. Government, Opposition teams)
    outcome TEXT NULL, -- e.g., 'Government won (3-0 decision)'
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- 5. Gallery Table
CREATE TABLE IF NOT EXISTS gallery (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    title TEXT NOT NULL,
    caption TEXT NULL,
    file_path TEXT NOT NULL,
    category TEXT NOT NULL, -- 'Weekly Sessions', 'National Tournaments', 'Social Events', 'Workshops'
    upload_date DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- 6. Achievements Table (Hall of Fame data)
CREATE TABLE IF NOT EXISTS achievements (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    title TEXT NOT NULL, -- e.g., 'Champion', 'Best Speaker', 'Runners-up'
    competition TEXT NOT NULL, -- e.g., '14th DUDS National Debate Championship'
    year INTEGER NOT NULL,
    team_members TEXT NOT NULL, -- Names of team members
    description TEXT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- 7. Recruitment Table (Applications)
CREATE TABLE IF NOT EXISTS recruitment (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL,
    email TEXT NOT NULL,
    phone TEXT NOT NULL,
    roll_no TEXT NOT NULL,
    department TEXT NOT NULL,
    academic_year TEXT NOT NULL, -- e.g., '1st Year', '2nd Year'
    debating_experience TEXT NULL, -- Brief past experience if any
    motivation TEXT NOT NULL, -- Why they want to join
    status TEXT NOT NULL DEFAULT 'pending', -- 'pending', 'approved', 'rejected'
    applied_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- 8. Contacts Table (Feedback / Messages)
CREATE TABLE IF NOT EXISTS contacts (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL,
    email TEXT NOT NULL,
    subject TEXT NOT NULL,
    message TEXT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Indexes for performance Optimization
CREATE INDEX IF NOT EXISTS idx_users_email ON users(email);
CREATE INDEX IF NOT EXISTS idx_members_status ON members(status);
CREATE INDEX IF NOT EXISTS idx_events_date ON events(event_date);
CREATE INDEX IF NOT EXISTS idx_debates_date ON debates(debate_date);
CREATE INDEX IF NOT EXISTS idx_recruitment_status ON recruitment(status);
CREATE INDEX IF NOT EXISTS idx_contacts_email ON contacts(email);
