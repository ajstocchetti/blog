-- populate db so site has content

-- `blog_entries`
INSERT INTO `blog_entries` (`entryID`, `title`, `location`, `dateDiscrete`, `dateOverride`, `uploadinst`, `filepath`, `permalink`, `disableComment`) VALUES
(6, 'vignettes', 'Chiang Mai', '2013-01-05 00:00:00', '', '2013-01-05 20:53:29', 'vignettes.part.php', '', 0),
(1, 'perception', 'Pittsburgh', '2008-04-10 00:00:00', 'Spring 2008', '2012-12-16 16:51:27', 'perception-2012Dec16-165127.part.php', '', 0),
(3, 'the gum disease gingivitis', '', '2012-01-15 00:00:00', '15 January 2012', '2012-12-16 16:49:23', 'thegumdiseasegingivitis.part.php', '', 0),
(2, 'the good things in life', '1902 Pike Dr #3, Fitchburg', '2011-07-20 20:00:00', '', '2012-12-16 16:50:07', 'thegoodthingsinlife.part.php', '', 0),
(7, 'Happenings', 'Panya', '2013-01-10 00:00:00', '', '2013-01-12 00:36:16', 'Happenings.part.php', '', 0),
(8, 'mayan solstice celebration', 'Pai (northern Thailand)', '2013-01-14 00:00:00', '', '2013-01-20 22:08:29', 'mayansolsticecelebration.part.php', '', 0),
(9, 'hot showers', 'Panya', '2013-01-19 00:00:00', '19 January 2013', '2013-01-20 22:09:12', 'hotshowers.part.php', '', 0),
(10, 'panya clean', 'Panya', '2013-01-25 00:00:00', '', '2013-01-25 20:24:02', 'panyaclean.part.php', '', 0),
(11, 'safety third', 'Panya', '2013-01-28 00:00:00', '', '2013-02-04 01:19:24', 'safetythird.part.php', '', 0),
(12, 'slow week in the rain', '', '2013-02-02 00:00:00', '', '2013-02-04 01:20:06', 'slowweekintherain.part.php', '', 0),
(13, 'friday fit club', 'Madison', '2013-02-06 00:00:00', '6 February 2013', '2013-02-10 02:49:45', 'fridayfitclub.part.php', '', 1),
(14, 'the spelling of god', 'somewhere near Burma', '2013-02-10 00:00:00', '10 February 2013', '2013-02-10 03:01:12', 'thespellingofgod.part.php', '', 0),
(15, 'visa run', 'Burma', '2013-02-10 00:00:00', '10 February 2013', '2013-02-10 03:01:45', 'visarun.part.php', '', 0),
(16, 'thai massage', 'Chiang Mai', '2013-03-01 13:00:00', '', '2013-03-01 06:09:31', 'thaimassage.part.php', '', 0),
(17, 'come visit me', 'Sukhpur, Bihar', '2013-07-10 00:00:00', '', '2013-07-10 09:02:23', 'comevisitme.part.php', '', 1),
(18, 'humbled', 'Humanure Power meeting table; India', '2013-07-12 00:00:00', '', '2013-07-12 10:20:46', 'humbled.part.php', '', 0),
(19, 'butter cream', 'Panya', '2013-07-26 00:00:00', '', '2013-07-26 05:39:46', 'buttercream.part.php', '', 0),
(20, 'destroying the evidence', '344 W Dayton Apt 504', '2013-08-31 12:00:00', '14 Jan 2012', '2013-08-31 21:07:25', 'destroyingtheevidence.part.php', '', 0),
(21, 'hoyt-schermerhorn', '', '2013-09-07 12:00:00', '', '2013-09-19 20:56:51', 'hoytschermerhorn.part.php', '', 0),
(22, 'community', 'New York', '2013-09-26 12:00:00', '', '2013-09-26 12:48:50', 'community.part.php', '', 0),
(23, 'eternal', 'everywhere', '2013-09-26 12:00:00', '', '2013-09-26 12:59:44', 'eternal.part.php', '', 1),
(24, 'high line park', 'lower manhattan', '2013-10-08 12:00:00', '', '2013-10-08 18:24:43', 'highlinepark.part.php', '', 0),
(25, 'dream', '', '2013-10-24 12:00:00', '', '2013-10-26 06:48:25', 'dream.part.php', '', 1),
(26, 'note to self', 'lower east side', '2013-11-07 12:00:00', '', '2013-11-08 06:41:08', 'notetoself.part.php', '', 0);

-- `GuestUsers`
-- personal data removed from github portfolio
INSERT INTO `GuestUsers` (`userID`, `userName`, `displayName`, `isActive`, `adminHold`) VALUES
(999, 'Test User', '', 0, 0),
(1004, 'Andy', 'Andy', 1, 0),
(1005, 'User 1', '', 1, 0),
(1006, 'User 2', '', 1, 0),
(1007, 'User 3', '', 1, 0),
(1008, 'User 4', '', 1, 0),
(1009, 'Public nuisance', '', 1, 1),
(1010, 'User 5', '', 1, 0),
(1011, 'User 6', '', 0, 0),

-- `blogComments`
INSERT INTO `blogComments` (`commentID`, `entryID`, `userID`, `comment`, `isDeleted`, `saveInst`) VALUES
(2, 11, 1007, 'That actually manages to be an even more creative way of sharpening a pencil than what used to go on in the archi studios at 4am...I''m impressed.', 0, '2013-02-04 13:03:42'),
(3, 11, 1007, 'Also, was the "massage only, no sex" place cheaper than the other places?', 0, '2013-02-04 13:04:00'),
(4, 12, 1007, 'What? You can''t leave the floor wonky and uneven and claim it was an artistic decision to make visitors more aware of their space? Pshaaa...', 0, '2013-02-04 13:07:25'),
(6, 14, 1006, 'By the way, in German all Nouns are capitalized.  You must know Someones Language to understand Their thinking!', 0, '2013-02-17 10:00:39'),
(7, 15, 1010, 'How did you do the masonry for the circle doorway? Sandbag as you went up and then remove? And where did you get the stones?  They look too nice to be field stones?', 0, '2013-02-25 17:37:24'),
(8, 16, 1007, 'Yea...can''t beat that exchange rate. :) I remember paying 25 baht for a full meal in Chiang Mai. Not the most nutritious thing in the world, but it was fantastic!', 0, '2013-03-01 07:03:31'),
(9, 16, 1007, 'Slightly belated, but the floor you were talking about before looks awesome in your photos. (Jealous.)\r\nP.S. Fluorescent yellow and green really brings out your blue eyes.', 0, '2013-03-01 07:08:09'),
(10, 15, 1007, 'Yay visas!\r\n\r\nSeconding Murph''s question.', 0, '2013-03-01 07:08:50'),
(11, 16, 1006, 'Soooo..... No posts for a while, do hope you are having a good day.  It is already tommorrow from here', 0, '2013-03-30 12:24:07'),
(12, 15, 1004, 'We built the circle window with a circular form. We put the form on the ground and then filled in around it with earthbags to hold it in place. Then, basically, we built a brick arch over the top of the form.', 0, '2013-04-04 08:59:47'),
(13, 15, 1004, 'When finished, we removed the form and filled in the bottom of the circle with more earthbags. What stones are you talking about?', 0, '2013-04-04 09:00:44');