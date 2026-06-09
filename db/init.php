<?php


require_once __DIR__ . '/../config/database.php';

try {
    $db = Database::getConnection();
    echo "Database connection successful.\n";

    
    $schemaFile = __DIR__ . '/schema.sql';
    if (!file_exists($schemaFile)) {
        throw new Exception("Schema file not found at " . $schemaFile);
    }
    
    $sql = file_get_contents($schemaFile);
    $db->exec($sql);
    echo "Tables and indexes created successfully.\n";

    
    $stmt = $db->query("SELECT COUNT(*) as count FROM users");
    $userCount = $stmt->fetch()['count'];

    if ($userCount == 0) {
        $adminEmail = 'admin@kds.org';
        $adminPassword = 'admin123';
        $adminPasswordHash = password_hash($adminPassword, PASSWORD_BCRYPT);
        
        $insertUser = $db->prepare("INSERT INTO users (name, email, password_hash, role) VALUES (?, ?, ?, ?)");
        $insertUser->execute([
            'Administrator KDS',
            $adminEmail,
            $adminPasswordHash,
            'admin'
        ]);
        echo "Admin user created successfully.\n";
        echo "Email: $adminEmail\nPassword: $adminPassword\n";
    }

    
    $stmt = $db->query("SELECT COUNT(*) as count FROM members");
    $memberCount = $stmt->fetch()['count'];
    if ($memberCount == 0) {
        $members = [
            [
                'name' => 'Prof. Dr. Mohammad Mashud',
                'role_title' => 'Chief Patron',
                'bio' => 'Professor at Mechanical Engineering Department, KUET. Promoting intellectual growth and supportive of rational dialogue on campus.',
                'image_path' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&q=80&w=400',
                'email' => 'mashud@me.kuet.ac.bd',
                'status' => 'active'
            ],
            [
                'name' => 'Adnan Rahman',
                'role_title' => 'President',
                'bio' => 'National speaker and seasoned debater. Leading KDS to new academic and debate milestones.',
                'image_path' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&q=80&w=400',
                'email' => 'adnan.cse19@stud.kuet.ac.bd',
                'status' => 'active'
            ],
            [
                'name' => 'Tasmia Jahan',
                'role_title' => 'General Secretary',
                'bio' => 'Passionate public speaker, trainer, and tournament organizer. Representing KDS at national tournaments.',
                'image_path' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&q=80&w=400',
                'email' => 'tasmia.ece20@stud.kuet.ac.bd',
                'status' => 'active'
            ],
            [
                'name' => 'Safwan Karim',
                'role_title' => 'Treasurer',
                'bio' => 'Managing KDS finance and logistics. British Parliamentary debate analyst.',
                'image_path' => 'https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?auto=format&fit=crop&q=80&w=400',
                'email' => 'safwan.me20@stud.kuet.ac.bd',
                'status' => 'active'
            ],
            [
                'name' => 'Nusrat Jahan',
                'role_title' => 'Alumni Board Member',
                'bio' => 'Former President of KDS (Batch 16). Champion of the 2019 National Debating Festival.',
                'image_path' => 'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?auto=format&fit=crop&q=80&w=400',
                'email' => 'nusrat.kds16@gmail.com',
                'status' => 'alumni'
            ]
        ];

        $insertMember = $db->prepare("INSERT INTO members (name, role_title, bio, image_path, email, status) VALUES (?, ?, ?, ?, ?, ?)");
        foreach ($members as $m) {
            $insertMember->execute([$m['name'], $m['role_title'], $m['bio'], $m['image_path'], $m['email'], $m['status']]);
        }
        echo "Members seeded.\n";
    }

    
    $stmt = $db->query("SELECT COUNT(*) as count FROM events");
    $eventCount = $stmt->fetch()['count'];
    if ($eventCount == 0) {
        $events = [
            [
                'title' => 'KDS National Debate Championship 2026',
                'description' => 'The flagship national debate festival of KUET Debating Society, inviting 32 top universities across the country to argue contemporary geopolitical issues in BP format.',
                'category' => 'Tournament',
                'event_date' => '2026-09-11',
                'event_time' => '09:00 AM',
                'venue' => 'Student Welfare Center (SWC), KUET',
                'image_path' => 'https://images.unsplash.com/photo-1475721027785-f74eccf877e2?auto=format&fit=crop&q=80&w=800',
                'registration_link' => 'https://forms.gle/kdsnational2026',
                'status' => 'upcoming'
            ],
            [
                'title' => 'Introduction to British Parliamentary (BP) Format',
                'description' => 'A workshop for beginners explaining the roles of all 8 speakers, points of information, and basic case build strategies in BP debates.',
                'category' => 'Workshop',
                'event_date' => '2026-05-30',
                'event_time' => '03:30 PM',
                'venue' => 'SWC Seminar Room, KUET',
                'image_path' => 'https://images.unsplash.com/photo-1524178232363-1fb2b075b655?auto=format&fit=crop&q=80&w=800',
                'registration_link' => 'https://forms.gle/bpworkshop',
                'status' => 'upcoming'
            ],
            [
                'title' => 'KDS Intra-KUET Debate Festival 2025',
                'description' => 'Annual inter-department debate tournament displaying fierce battles among the departments of KUET.',
                'category' => 'Tournament',
                'event_date' => '2025-11-20',
                'event_time' => '02:00 PM',
                'venue' => 'KUET Auditorium',
                'image_path' => 'https://images.unsplash.com/photo-1511578314322-379afb476865?auto=format&fit=crop&q=80&w=800',
                'registration_link' => '',
                'status' => 'past'
            ]
        ];

        $insertEvent = $db->prepare("INSERT INTO events (title, description, category, event_date, event_time, venue, image_path, registration_link, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        foreach ($events as $ev) {
            $insertEvent->execute([$ev['title'], $ev['description'], $ev['category'], $ev['event_date'], $ev['event_time'], $ev['venue'], $ev['image_path'], $ev['registration_link'], $ev['status']]);
        }
        echo "Events seeded.\n";
    }

    
    $stmt = $db->query("SELECT COUNT(*) as count FROM debates");
    $debateCount = $stmt->fetch()['count'];
    if ($debateCount == 0) {
        $debates = [
            [
                'title' => 'Grand Finale: The Artificial Intelligence Dilemma',
                'description' => 'A heavy-weight match challenging the rise of generative AI tools and cognitive automating agents on ethical and legal grounds.',
                'debate_type' => 'British Parliamentary',
                'motion' => 'This House would hold developers of autonomous systems legally responsible for the actions of their AI agents.',
                'video_url' => 'dQw4w9WgXcQ', 
                'debate_date' => '2025-11-21',
                'category' => 'English',
                'participants' => 'Gov: CSE Dept | Opp: EEE Dept',
                'outcome' => 'Government won (Decision: 3-0)'
            ],
            [
                'title' => 'Intra-KUET Final: Climate Change Responsibility',
                'description' => 'A fiery traditional debate regarding climate adaptation funds and responsibilities between developing and developed countries.',
                'debate_type' => 'Traditional',
                'motion' => 'এই সংসদ জলবায়ু পরিবর্তনের ক্ষতিপূরণে উন্নত দেশগুলোর আইনি বাধ্যবাধকতা জারি করবে।',
                'video_url' => 'dQw4w9WgXcQ',
                'debate_date' => '2025-11-20',
                'category' => 'Bangla',
                'participants' => 'Gov: ME Dept | Opp: ECE Dept',
                'outcome' => 'Opposition won (Decision: 2-1)'
            ]
        ];

        $insertDebate = $db->prepare("INSERT INTO debates (title, description, debate_type, motion, video_url, debate_date, category, participants, outcome) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        foreach ($debates as $d) {
            $insertDebate->execute([$d['title'], $d['description'], $d['debate_type'], $d['motion'], $d['video_url'], $d['debate_date'], $d['category'], $d['participants'], $d['outcome']]);
        }
        echo "Debates seeded.\n";
    }

    
    $stmt = $db->query("SELECT COUNT(*) as count FROM achievements");
    $achievementCount = $stmt->fetch()['count'];
    if ($achievementCount == 0) {
        $achievements = [
            [
                'title' => 'National Champions',
                'competition' => '8th SUDS National Debate Fest',
                'year' => 2024,
                'team_members' => 'Adnan Rahman, Sadia Kabir, Tanvir Ahmed',
                'description' => 'Won the championship trophy in English British Parliamentary format outperforming 24 teams from premier universities.'
            ],
            [
                'title' => 'Best Speaker Award',
                'competition' => 'BUET National Debate Festival',
                'year' => 2023,
                'team_members' => 'Adnan Rahman',
                'description' => 'Adjudged the Best Speaker of the tournament for outstanding performance in arguments, analytics, and rhetoric.'
            ],
            [
                'title' => 'Runner-up',
                'competition' => 'IUT Professionals BP 2023',
                'year' => 2023,
                'team_members' => 'Tasmia Jahan, Safwan Karim',
                'description' => 'Fought fiercely in the Grand Finale regarding financial banking reforms and secured the runners-up position.'
            ]
        ];

        $insertAchievement = $db->prepare("INSERT INTO achievements (title, competition, year, team_members, description) VALUES (?, ?, ?, ?, ?)");
        foreach ($achievements as $ach) {
            $insertAchievement->execute([$ach['title'], $ach['competition'], $ach['year'], $ach['team_members'], $ach['description']]);
        }
        echo "Achievements seeded.\n";
    }

    
    $stmt = $db->query("SELECT COUNT(*) as count FROM gallery");
    $galleryCount = $stmt->fetch()['count'];
    if ($galleryCount == 0) {
        $photos = [
            [
                'title' => 'Weekly Session Practice',
                'caption' => 'General members debating during our regular Saturday session at SWC.',
                'file_path' => 'https://images.unsplash.com/photo-1517486808906-6ca8b3f04846?auto=format&fit=crop&q=80&w=800',
                'category' => 'Weekly Sessions'
            ],
            [
                'title' => 'National Championship Team',
                'caption' => 'The winning team celebrating with the championship trophy.',
                'file_path' => 'https://images.unsplash.com/photo-1544531586-fde5298cdd40?auto=format&fit=crop&q=80&w=800',
                'category' => 'National Tournaments'
            ],
            [
                'title' => 'Winter Workshop 2024',
                'caption' => 'Group photo of participants and trainers after the public speaking masterclass.',
                'file_path' => 'https://images.unsplash.com/photo-1515187029135-18ee286d815b?auto=format&fit=crop&q=80&w=800',
                'category' => 'Workshops'
            ],
            [
                'title' => 'KDS Reunion Dinner',
                'caption' => 'Alumni and current active members at the annual gala social dinner.',
                'file_path' => 'https://images.unsplash.com/photo-1469371670807-013ccf25f16a?auto=format&fit=crop&q=80&w=800',
                'category' => 'Social Events'
            ]
        ];

        $insertPhoto = $db->prepare("INSERT INTO gallery (title, caption, file_path, category) VALUES (?, ?, ?, ?)");
        foreach ($photos as $p) {
            $insertPhoto->execute([$p['title'], $p['caption'], $p['file_path'], $p['category']]);
        }
        echo "Gallery seeded.\n";
    }

    
    $stmt = $db->query("SELECT COUNT(*) as count FROM recruitment");
    $recCount = $stmt->fetch()['count'];
    if ($recCount == 0) {
        $recruits = [
            [
                'name' => 'Tahsin Ul Alam',
                'email' => 'tahsin.cse24@stud.kuet.ac.bd',
                'phone' => '01712345678',
                'roll_no' => '2407001',
                'department' => 'CSE',
                'academic_year' => '1st Year',
                'debating_experience' => 'Participated in college debate clubs, standard Traditional formats.',
                'motivation' => 'I want to improve my critical analytical skills and overcome my public speaking fear. KDS provides the best platform on campus to do this.'
            ],
            [
                'name' => 'Farhana Kabir',
                'email' => 'farhana.eee23@stud.kuet.ac.bd',
                'phone' => '01812345678',
                'roll_no' => '2303080',
                'department' => 'EEE',
                'academic_year' => '2nd Year',
                'debating_experience' => 'None, but highly motivated to learn English BP debates.',
                'motivation' => 'I love watching university debates online (like World Universities Debating Championships) and want to learn how to present arguments with logic and facts.'
            ]
        ];

        $insertRec = $db->prepare("INSERT INTO recruitment (name, email, phone, roll_no, department, academic_year, debating_experience, motivation) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        foreach ($recruits as $r) {
            $insertRec->execute([$r['name'], $r['email'], $r['phone'], $r['roll_no'], $r['department'], $r['academic_year'], $r['debating_experience'], $r['motivation']]);
        }
        echo "Recruitment applications seeded.\n";
    }

    echo "Database setup completed successfully!\n";

} catch (Exception $e) {
    die("Seeding Error: " . $e->getMessage() . "\n");
}
