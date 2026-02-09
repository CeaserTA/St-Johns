<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Event;
use Carbon\Carbon;

class EventsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $events = [
            // Events
            [
                'title' => 'Sunday Worship Service',
                'type' => 'event',
                'description' => 'Join us for our weekly Sunday worship service with inspiring messages and uplifting music.',
                'content' => "Experience a powerful time of worship and fellowship. Our service includes:\n\n- Contemporary worship music\n- Inspiring sermon\n- Prayer and communion\n- Children's ministry available\n\nAll are welcome!",
                'location' => 'Main Sanctuary',
                'starts_at' => Carbon::now()->next('Sunday')->setTime(9, 0),
                'ends_at' => Carbon::now()->next('Sunday')->setTime(11, 30),
                'is_active' => true,
                'is_pinned' => true,
            ],
            [
                'title' => 'Youth Fellowship Night',
                'type' => 'event',
                'description' => 'An evening of fun, games, and spiritual growth for young people aged 13-25.',
                'content' => "Join us for an exciting youth fellowship night! Activities include:\n\n- Icebreaker games\n- Worship session\n- Small group discussions\n- Snacks and refreshments\n\nBring a friend!",
                'location' => 'Youth Center',
                'starts_at' => Carbon::now()->addDays(5)->setTime(18, 0),
                'ends_at' => Carbon::now()->addDays(5)->setTime(21, 0),
                'is_active' => true,
            ],
            [
                'title' => 'Community Outreach Program',
                'type' => 'event',
                'description' => 'Join us as we serve our local community with food distribution and prayer.',
                'content' => "Be part of making a difference in our community!\n\n- Food package distribution\n- Free medical checkups\n- Prayer ministry\n- Children's activities\n\nVolunteers needed! Sign up today.",
                'location' => 'Community Center',
                'starts_at' => Carbon::now()->addDays(12)->setTime(10, 0),
                'ends_at' => Carbon::now()->addDays(12)->setTime(15, 0),
                'is_active' => true,
            ],
            [
                'title' => 'Bible Study - Book of Romans',
                'type' => 'event',
                'description' => 'Deep dive into the Book of Romans with interactive discussions and practical applications.',
                'content' => "Join our weekly Bible study series on the Book of Romans.\n\n- Verse-by-verse study\n- Group discussions\n- Practical life applications\n- Q&A session\n\nStudy materials provided.",
                'location' => 'Fellowship Hall',
                'starts_at' => Carbon::now()->addDays(3)->setTime(19, 0),
                'ends_at' => Carbon::now()->addDays(3)->setTime(20, 30),
                'is_active' => true,
            ],
            [
                'title' => 'Easter Celebration Service',
                'type' => 'event',
                'description' => 'Celebrate the resurrection of Jesus Christ with a special Easter service.',
                'content' => "Join us for a special Easter celebration!\n\n- Special worship performances\n- Easter message\n- Communion service\n- Easter egg hunt for children\n- Fellowship lunch after service\n\nInvite your family and friends!",
                'location' => 'Main Sanctuary',
                'starts_at' => Carbon::now()->addDays(45)->setTime(8, 0),
                'ends_at' => Carbon::now()->addDays(45)->setTime(13, 0),
                'is_active' => true,
                'is_pinned' => true,
            ],
            
            // Announcements
            [
                'title' => 'New Church Website Launch',
                'type' => 'announcement',
                'description' => 'We are excited to announce the launch of our new church website with enhanced features.',
                'content' => "Our new website is now live!\n\nNew features include:\n- Online giving platform\n- Event registration\n- Sermon archives\n- Prayer request submission\n- Member directory\n\nVisit us at www.stjohnsparish.org",
                'is_active' => true,
                'expires_at' => Carbon::now()->addDays(30),
            ],
            [
                'title' => 'Volunteer Opportunities Available',
                'type' => 'announcement',
                'description' => 'We are looking for volunteers to serve in various ministries. Your time and talents are needed!',
                'content' => "Join our ministry teams!\n\nWe need volunteers for:\n- Children's ministry\n- Worship team (musicians/singers)\n- Hospitality team\n- Media/tech team\n- Prayer ministry\n\nContact the church office to sign up.",
                'is_active' => true,
                'expires_at' => Carbon::now()->addDays(60),
            ],
            [
                'title' => 'Church Office Hours Update',
                'type' => 'announcement',
                'description' => 'Please note our updated office hours effective immediately.',
                'content' => "New office hours:\n\nMonday - Friday: 9:00 AM - 5:00 PM\nSaturday: 10:00 AM - 2:00 PM\nSunday: Closed\n\nFor emergencies, please call the pastor's hotline.",
                'is_active' => true,
                'expires_at' => Carbon::now()->addDays(90),
            ],
            [
                'title' => 'Prayer Chain Ministry',
                'type' => 'announcement',
                'description' => 'Join our prayer chain to intercede for members and community needs.',
                'content' => "Be part of our prayer warriors!\n\nHow it works:\n- Receive prayer requests via WhatsApp group\n- Commit to praying daily\n- Share testimonies of answered prayers\n\nTo join, contact Sister Mary at the church office.",
                'is_active' => true,
                'expires_at' => Carbon::now()->addDays(45),
            ],
            [
                'title' => 'Annual Church Retreat Registration Open',
                'type' => 'announcement',
                'description' => 'Registration is now open for our annual church retreat. Limited spaces available!',
                'content' => "Don't miss our annual retreat!\n\nDate: July 15-17, 2026\nLocation: Lake Victoria Resort\nTheme: 'Renewed in His Presence'\n\nPackage includes:\n- Accommodation\n- All meals\n- Conference materials\n- Transportation\n\nEarly bird discount until March 31st!\nRegister at the church office.",
                'is_active' => true,
                'is_pinned' => true,
                'expires_at' => Carbon::now()->addDays(120),
            ],
        ];

        foreach ($events as $eventData) {
            Event::create($eventData);
        }

        $this->command->info('Successfully seeded 10 events and announcements!');
    }
}
