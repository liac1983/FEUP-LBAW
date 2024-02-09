--
-- Use a specific schema and set it as default - thingy.
--
DROP SCHEMA IF EXISTS lbaw2321 CASCADE;
CREATE SCHEMA IF NOT EXISTS lbaw2321;
SET search_path TO lbaw2321;
SET DateStyle TO European;

--
-- Drop any existing tables.
--
DROP TABLE IF EXISTS users CASCADE;
DROP TABLE IF EXISTS events CASCADE;
DROP TABLE IF EXISTS eventInvitation CASCADE;
DROP TABLE IF EXISTS eventTicket CASCADE;
DROP TABLE IF EXISTS tag CASCADE;
DROP TABLE IF EXISTS comments CASCADE;
DROP TABLE IF EXISTS attendance CASCADE;
DROP TABLE IF EXISTS notification CASCADE;


DROP TYPE IF EXISTS user_status_types;
DROP TYPE IF EXISTS event_status_types;
DROP TYPE IF EXISTS invite_response_type;
DROP TYPE IF EXISTS tag_type;
DROP TYPE IF EXISTS notification_type;


--
-- Create types.
--

CREATE TYPE user_status_types AS ENUM ('Active', 'Suspended', 'Banned');
CREATE TYPE event_status_types AS ENUM ('Active', 'Suspended', 'Banned');
CREATE TYPE participation_type AS ENUM ('Going','Maybe','Not Going','Pending');
CREATE TYPE tag_type AS ENUM ('Outdoor','Indoor','Music','Tech','Fitness','Education','Art','Science','Food','Travel','Gaming','Fashion');
CREATE TYPE notification_type AS ENUM ('event_notification','comment_notification');


--
-- Create tables.
--

CREATE TABLE users (
  id SERIAL PRIMARY KEY,
  username VARCHAR(256) UNIQUE NOT NULL,
  name VARCHAR(256) NOT NULL,
  email VARCHAR(256) UNIQUE NOT NULL,
  password VARCHAR(256) NOT NULL,
  userStatus user_status_types NOT NULL DEFAULT 'Active',
  isAdmin BOOLEAN DEFAULT FALSE,
  profile_photo VARCHAR(255) DEFAULT 'user_profile.png',
  remember_token VARCHAR(100) NULL
);

CREATE TABLE tag (
  id SERIAL PRIMARY KEY,
  name tag_type NOT NULL
);

CREATE TABLE events (
  id SERIAL PRIMARY KEY,
  eventName VARCHAR(256) NOT NULL,
  startDateTime TIMESTAMP NOT NULL,
  endDateTime TIMESTAMP NOT NULL,
  registrationEndTime TIMESTAMP NOT NULL,
  local VARCHAR(256) NOT NULL,
  description VARCHAR(512) NOT NULL,
  capacity INTEGER NOT NULL CHECK (capacity>0),
  isPublic BOOLEAN NOT NULL DEFAULT TRUE,
  status event_status_types NOT NULL,
  owner_id INTEGER NOT NULL REFERENCES users (id) ON UPDATE CASCADE,
  tag_id INTEGER REFERENCES tag (id) ON UPDATE CASCADE,
  photo VARCHAR(255)
);

CREATE TABLE eventInvitation (
  id SERIAL PRIMARY KEY,
  sentDate TIMESTAMP NOT NULL CHECK (sentDate <= now()),
  event_id INTEGER NOT NULL REFERENCES events (id) ON UPDATE CASCADE,
  user_invited_id INTEGER NOT NULL REFERENCES users (id) ON UPDATE CASCADE,
  user_host_id INTEGER NOT NULL REFERENCES users (id) ON UPDATE CASCADE,
  decision participation_type
);

CREATE TABLE eventTicket (
  id SERIAL PRIMARY KEY,
  price NUMERIC(4,2) NOT NULL CHECK (price >= 0) DEFAULT 0,
  event_id INTEGER NOT NULL REFERENCES events (id) ON UPDATE CASCADE,
  eventTicketNumber INTEGER /*CHECK (eventTicketNumber > 0 AND eventTicketNumber <= (SELECT capacity FROM events WHERE id = event_id))*/
);

CREATE TABLE comments(
  id SERIAL PRIMARY KEY,
  content VARCHAR(512) NOT NULL,
  owner_id INTEGER NOT NULL REFERENCES users(id) ON UPDATE CASCADE,
  event_id INTEGER NOT NULL REFERENCES events (id) ON UPDATE CASCADE,
  dateTime TIMESTAMP NOT NULL CHECK (dateTime<=now())
);

CREATE TABLE attendance (
  user_id INTEGER,
  event_id INTEGER,
  participation participation_type,
  wishlist BOOLEAN NOT NULL DEFAULT FALSE,
  PRIMARY KEY (user_id, event_id),
  FOREIGN KEY (user_id) REFERENCES users(id) ON UPDATE CASCADE,
  FOREIGN KEY (event_id) REFERENCES events(id) ON UPDATE CASCADE
);


/* temos de ver como fica PK quando a notificação é do tipo comment/event porque tem de ter o ID respetivo*/
CREATE TABLE notification (
  id SERIAL PRIMARY KEY,
  dateTime TIMESTAMP NOT NULL CHECK (dateTime<=now()),  
  notified_user INTEGER NOT NULL REFERENCES users(id) ON UPDATE CASCADE,
  type notification_type NOT NULL,
  description VARCHAR(512)
);


--
-- Insert values.
--


INSERT INTO users (username, name, email, password, userStatus, isAdmin, profile_photo) 
VALUES 
  ('alice_wonderland', 'Alice Wonderland', 'alice@example.com', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W', 'Active', FALSE, 'profile_photos/user_profile.png'), -- password 1234
  ('bob_marley', 'Bob Marley', 'bob@example.com', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W', 'Active', FALSE, 'profile_photos/user_profile.png'),
  ('charlie_chaplin', 'Charlie Chaplin', 'charlie@example.com', 'charliepass', 'Active', FALSE, 'profile_photos/user_profile.png'),
  ('david_copperfield', 'David Copperfield', 'david@example.com', 'davidpass', 'Active', FALSE, 'profile_photos/user_profile.png'),
  ('eve_gardner', 'Eve Gardner', 'eve@example.com', 'evepass', 'Suspended',FALSE, 'profile_photos/user_profile.png'),
  ('frank_fisher', 'Frank Fisher', 'frank@example.com', 'frankpass', 'Active', FALSE, 'profile_photos/user_profile.png'),
  ('grace_gibson', 'Grace Gibson', 'grace@example.com', 'gracepass', 'Active', FALSE, 'profile_photos/user_profile.png'),
  ('hank_harrison', 'Hank Harrison', 'hank@example.com', 'hankpass', 'Active', FALSE, 'profile_photos/user_profile.png'),
  ('irene_ingram', 'Irene Ingram', 'irene@example.com', 'irenepass', 'Active', FALSE, 'profile_photos/user_profile.png'),
  ('jason_jones', 'Jason Jones', 'jason@example.com', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W', 'Active', TRUE, 'profile_photos/user_profile.png'),
  ('kate_kennedy', 'Kate Kennedy', 'kate@example.com', 'katepass', 'Active', FALSE, 'profile_photos/user_profile.png'),
  ('leonardo_lucas', 'Leonardo Lucas', 'leonardo@example.com', 'leonardopass', 'Active', FALSE, 'profile_photos/user_profile.png'),
  ('megan_miller', 'Megan Miller', 'megan@example.com', 'meganpass', 'Active', FALSE, 'profile_photos/user_profile.png'),
  ('nathan_nelson', 'Nathan Nelson', 'nathan@example.com', 'nathanpass', 'Active', FALSE, 'profile_photos/user_profile.png'),
  ('olivia_owens', 'Olivia Owens', 'olivia@example.com', 'oliviapass', 'Active', FALSE, 'profile_photos/user_profile.png'),
  ('peter_perez', 'Peter Perez', 'peter@example.com', 'peterpass', 'Active', FALSE, 'profile_photos/user_profile.png'),
  ('quincy_queen', 'Quincy Queen', 'quincy@example.com', 'quincypass', 'Active', FALSE, 'profile_photos/user_profile.png'),
  ('rachel_ross', 'Rachel Ross', 'rachel@example.com', 'rachelpass', 'Active', FALSE, 'profile_photos/user_profile.png'),
  ('samuel_smith', 'Samuel Smith', 'samuel@example.com', 'samuelpass', 'Active', FALSE, 'profile_photos/user_profile.png'),
  ('tina_taylor', 'Tina Taylor', 'tina@example.com', 'tinapass', 'Active', FALSE, 'profile_photos/user_profile.png'),
  ('ulysses_urban', 'Ulysses Urban', 'ulysses@example.com', 'ulyssespass', 'Suspended', FALSE, 'profile_photos/user_profile.png'),
  ('victor_vargas', 'Victor Vargas', 'victor@example.com', 'victorpass', 'Suspended', FALSE, 'profile_photos/user_profile.png'),
  ('wanda_white', 'Wanda White', 'wanda@example.com', 'wandapass', 'Active', FALSE, 'profile_photos/user_profile.png'),
  ('xander_xiao', 'Xander Xiao', 'xander@example.com', 'xanderpass', 'Active', FALSE, 'profile_photos/user_profile.png'),
  ('yvonne_york', 'Yvonne York', 'yvonne@example.com', 'yvonnepass', 'Active', FALSE, 'profile_photos/user_profile.png'),
  ('zachary_zane', 'Zachary Zane', 'zachary@example.com', 'zacharypass', 'Active', FALSE, 'profile_photos/user_profile.png');



INSERT INTO tag (name) VALUES 
  ('Music'),
  ('Tech'),
  ('Fitness'),
  ('Education'),
  ('Art'),
  ('Science'),
  ('Food'),
  ('Travel'),
  ('Gaming'),
  ('Fashion');


INSERT INTO events (eventName, startDateTime, endDateTime, registrationEndTime, local, description, capacity, isPublic, status, owner_id, tag_id, photo)
VALUES 
  ('Concert Night', '2023-09-10 19:00:00', '2023-09-10 23:00:00', '2023-09-05 23:59:59', 'Music Hall', 'Live music and entertainment', 100, true, 'Active', 3, 1, 'concertnight.webp'),
  ('Tech Workshop', '2023-10-15 10:00:00', '2023-10-15 16:00:00', '2023-10-10 23:59:59', 'Tech Hub', 'Hands-on coding experience', 50, true, 'Active', 4, 2, 'techworkshop.jpeg'),
  ('Fitness Challenge', '2023-11-05 08:00:00', '2023-11-05 12:00:00', '2023-11-01 23:59:59', 'Fitness Center', 'Join us for a morning workout', 30, true, 'Active', 5, 3, 'fitnesschallenge.webp'),
  ('Science Fair', '2023-12-01 13:00:00', '2023-12-01 17:00:00', '2023-11-25 23:59:59', 'Science Museum', 'Discover the wonders of science', 80, true, 'Active', 6, 6, 'sciencefair.jpeg'),
  ('Art Exhibition', '2024-01-20 11:00:00', '2024-01-20 18:00:00', '2024-01-15 23:59:59', 'Art Gallery', 'Showcasing local artists', 120, true, 'Active', 7, 5, 'artgallery.webp'),
  ('Cooking Class', '2024-02-08 17:30:00', '2024-02-08 20:30:00', '2024-02-01 23:59:59', 'Culinary School', 'Learn to cook delicious dishes', 25, true, 'Active', 8, 7, 'cookingclass.jpeg'),
  ('Travel Talk', '2024-03-12 15:00:00', '2024-03-12 17:00:00', '2024-03-07 23:59:59', 'Community Center', 'Share travel stories and tips', 40, true, 'Active', 9, 8, 'traveltalk.jpeg'),
  ('Gaming Tournament', '2024-04-05 18:00:00', '2024-04-05 22:00:00', '2024-04-01 23:59:59', 'Gaming Arena', 'Compete in various gaming challenges', 60, true, 'Active', 10, 9, 'gamingtournament.webp'),
  ('Fashion Show', '2024-05-22 14:00:00', '2024-05-22 17:00:00', '2024-05-17 23:59:59', 'Fashion Mall', 'Showcasing the latest trends', 75, true, 'Active', 1, 10, 'fashionshow.jpeg'),
  ('Community Cleanup', '2024-06-10 09:00:00', '2024-06-10 12:00:00', '2024-06-05 23:59:59', 'Community Park', 'Join hands for a cleaner community', 50, true, 'Active', 2, 4, 'communitycleanup.jpeg'),
  ('Private Meeting', '2023-09-20 14:00:00', '2023-09-20 16:00:00', '2023-09-15 23:59:59', 'Corporate Office', 'Internal team discussions', 20, false, 'Active', 3, 10, 'privatemeeting.jpeg'),
  ('VIP Networking Dinner', '2023-10-25 19:30:00', '2023-10-25 22:30:00', '2023-10-20 23:59:59', 'Exclusive Venue', 'Exclusive networking event', 30, false, 'Active', 4, 1, 'vipmeeting.jpeg'),
  ('Executive Retreat', '2023-11-15 08:00:00', '2023-11-17 17:00:00', '2023-11-10 23:59:59', 'Luxury Resort', 'Strategic planning retreat', 15, false, 'Active', 5, 3, 'executiveretreat.jpeg'),
  ('Confidential Product Launch', '2023-12-05 15:00:00', '2023-12-05 18:00:00', '2023-11-30 23:59:59', 'Top-Secret Location', 'Unveiling a groundbreaking product', 40, false, 'Active', 6, 4, 'productlaunch.png'),
  ('Board of Directors Meeting', '2024-01-30 10:00:00', '2024-01-30 12:00:00', '2024-01-25 23:59:59', 'Corporate Headquarters', 'High-level strategic discussions', 10, false, 'Active', 7, 5, 'boardmeeting.jpeg'),
  ('VIP Art Preview', '2024-02-15 18:00:00', '2024-02-15 21:00:00', '2024-02-10 23:59:59', 'Private Gallery', 'Exclusive preview for VIP guests', 25, false, 'Active', 8, 6, 'vipartpreview.webp'),
  ('Leadership Seminar', '2024-03-20 09:30:00', '2024-03-20 16:30:00', '2024-03-15 23:59:59', 'Conference Center', 'Development for organizational leaders', 50, false, 'Active', 9, 7, 'leadershipseminar.jpeg'),
  ('Private Concert', '2024-04-10 20:00:00', '2024-04-10 22:30:00', '2024-04-05 23:59:59', 'Exclusive Venue', 'Intimate concert experience', 15, false, 'Active', 10, 8, 'privateconcert.webp'),
  ('Corporate Wellness Retreat', '2024-05-28 08:00:00', '2024-05-30 17:00:00', '2024-05-23 23:59:59', 'Wellness Resort', 'Promoting employee well-being', 20, false, 'Active', 1, 9, 'corporatewellness.jpg'),
  ('Exclusive Product Demo', '2024-06-15 14:00:00', '2024-06-15 16:30:00', '2024-06-10 23:59:59', 'Product Showroom', 'Invite-only product demonstration', 30, false, 'Active', 2, 2, 'productdemo.webp');


INSERT INTO eventInvitation (sentDate, event_id, user_invited_id, user_host_id, decision)
VALUES 
  ('2023-09-01 08:00:00', 3, 4, 3, 'Going'),
  ('2023-10-01 11:30:00', 4, 3, 4, 'Maybe'),
  ('2023-11-01 16:00:00', 5, 6, 5, 'Going'),
  ('2023-08-01 09:30:00', 6, 5, 6, 'Not Going'),
  ('2023-01-01 14:45:00', 7, 8, 7, 'Going'),
  ('2023-02-01 19:20:00', 8, 7, 8, 'Maybe'),
  ('2023-03-01 13:10:00', 9, 10, 9, 'Not Going'),
  ('2023-04-01 17:45:00', 10, 9, 10, 'Going'),
  ('2023-05-01 12:30:00', 1, 2, 1, 'Going'),
  ('2023-06-01 10:15:00', 2, 1, 2, 'Maybe'),
  ('2023-05-01 12:30:00', 11, 1, 13, 'Going'),
  ('2023-06-01 10:15:00', 12, 1, 19, 'Maybe');


INSERT INTO eventTicket (price, event_id, eventTicketNumber) 
VALUES 
  (15.00, 3, 20),
  (25.00, 4, 40),
  (10.00, 5, 15),
  (30.00, 6, 50),
  (12.00, 7, 25),
  (20.00, 8, 30),
  (18.00, 9, 35),
  (22.00, 10, 45),
  (15.00, 1, 20),
  (25.00, 2, 40);


INSERT INTO comments (content, owner_id, event_id, dateTime) 
VALUES 
  ('Can not wait for the concert!', 3, 3, '2023-09-02 14:00:00'),
  ('Tech workshops are always informative!', 4, 4, '2023-10-02 17:30:00'),
  ('Ready to challenge myself!', 5, 5, '2023-11-06 10:00:00'),
  ('Science is fascinating!', 6, 6, '2023-11-02 15:15:00'),
  ('Art speaks louder than words.', 7, 7, '2022-01-21 12:45:00'),
  ('Cooking is an art too!', 8, 8, '2022-02-09 18:00:00'),
  ('Share your travel adventures!', 9, 9, '2021-03-13 16:20:00'),
  ('Gaming enthusiasts, unite!', 10, 10, '2022-04-06 19:30:00'),
  ('Fashion forward!', 1, 1, '2021-05-23 15:30:00'),
  ('Let us make our community better!', 2, 2, '2023-06-05 10:30:00'),
  ('Looking forward to the music festival!', 5, 3, '2023-09-03 18:45:00'),
  ('Great learning experience at the coding bootcamp!', 7, 4, '2023-10-15 14:00:00'),
  ('Exploring new technologies at the tech conference!', 8, 5, '2023-11-10 11:30:00'),
  ('Attending a workshop on space exploration!', 1, 6, '2023-11-05 13:45:00'),
  ('Excited for the upcoming art exhibition!', 2, 7, '2022-02-18 16:20:00'),
  ('Mastering new recipes at the cooking class!', 4, 8, '2022-03-15 19:00:00'),
  ('Capturing beautiful moments during travel!', 6, 9, '2021-04-20 09:45:00'),
  ('Gaming night with friends!', 3, 10, '2022-05-10 20:15:00'),
  ('Showcasing the latest fashion trends!', 10, 1, '2021-06-30 17:00:00'),
  ('Community cleanup initiative – join us!', 6, 2, '2023-07-15 08:30:00');


INSERT INTO attendance (user_id, event_id, participation, wishlist)
VALUES 
  (1, 3, 'Going', false),
  (1, 7, 'Going', false),
  (2, 4, 'Maybe', true),
  (3, 5, 'Going', false),
  (4, 6, 'Not Going', false),
  (5, 7, 'Going', false),
  (6, 8, 'Maybe', false),
  (7, 9, 'Not Going', true),
  (8, 10, 'Going', false),
  (9, 1, 'Going', false),
  (10, 2, 'Maybe', false),
  (1, 10, 'Not Going', true),
  (2, 9, 'Going', false),
  (3, 8, 'Maybe', false),
  (4, 7, 'Going', false),
  (5, 6, 'Not Going', true),
  (6, 5, 'Going', false),
  (7, 4, 'Maybe', false),
  (8, 3, 'Going', false),
  (9, 2, 'Going', false),
  (11, 1, 'Not Going', false),
  (14, 8, 'Going', false),
  (20, 7, 'Maybe', true),
  (19, 6, 'Going', false),
  (15, 5, 'Not Going', false),
  (23, 4, 'Going', false),
  (12, 3, 'Maybe', false),
  (17, 2, 'Not Going', true),
  (18, 1, 'Going', false),
  (19, 10, 'Going', false),
  (20, 9, 'Maybe', false),
  (21, 6, 'Not Going', true),
  (22, 5, 'Going', false),
  (13, 4, 'Maybe', false),
  (16, 9, 'Going', false),
  (19, 9, 'Going', false),
  (24, 1, 'Not Going', false);

