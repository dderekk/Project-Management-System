<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('projects')->insert([
            'title'=>'First Robotic Project',
            'description' => "The First Project marked a significant milestone for our team. While it was just the beginning, it embodied our dedication, hard work, and passion. Every challenge faced was a lesson learned, setting the stage for future endeavors",
            'trimester'=> 1,
            'team_size'=>4,
            'year' => 2024,
            'inpID' => 3,
            'coordinator_name'=>'Bobie',
            'coordinator_email'=>'Bob1@gamil.com',
            'complexity'=>'easy'
        ]);
        DB::table('projects')->insert([
            'title'=>'Nexa Vision of Social Door War',
            'description' => "NexaVision represents the future of digital visualization. Harnessing the power of advanced algorithms and immersive graphics, this project aims to redefine user experiences. From virtual reality to data representation, NexaVision stands as a beacon of innovation, pushing boundaries and setting new industry standards. It's not just a project it's a revolution",
            'trimester'=> 2,
            'team_size'=>3,
            'year' => 2024,
            'inpID' => 2,
            'coordinator_name'=>'Alice',
            'coordinator_email'=>'Alice1@gamil.com',
            'complexity'=>'easy'
        ]);
        DB::table('projects')->insert([
            'title'=>'Operation Fluffy Bunny',
            'description' => "FluffyBunnyOps is not your typical tech venture. Imagine combining the fluffiness of bunnies with the seriousness of operations. It's a whirlwind of furry chaos, ensuring that every task is tackled with a hop, skip, and a jump. Who said operations couldn't be cuddly and efficient at the same time?",
            'trimester'=> 2,
            'team_size'=>4,
            'year' => 2024,
            'inpID' => 3,
            'coordinator_name'=>'Bobie',
            'coordinator_email'=>'Bob1@gamil.com',
            'complexity'=>'easy'
        ]);
        DB::table('projects')->insert([
            'title'=>'Pickle Unicorn Zap',
            'description' => "Introducing PickleUnicornZap, where pickles meet mythical creatures in a zappy digital realm. It's the quirkiest platform ever, blending briny humor with unicorn magic. If you've ever wondered about the electrifying adventures of pickled unicorns, this is your one-stop destination. Dive in, and embrace the pickle!",
            'trimester'=> 1,
            'team_size'=>4,
            'year' => 2025,
            'inpID' => 4,
            'coordinator_name'=>'Catherine',
            'coordinator_email'=>'Catherine@gamil.com',
            'complexity'=>'hard'
        ]);
        DB::table('projects')->insert([
            'title'=>'Muffin Top Mingle',
            'description' => "MuffinTopMingle is the ultimate social network for pastries with a little extra. Here, muffins with the most glorious tops come to shine and socialize. It's a world where the fluffier your top, the cooler you are. Join the muffin revolution and let your top do the talking!",
            'trimester'=> 1,
            'team_size'=>3,
            'year' => 2025,
            'inpID' => 5,
            'coordinator_name'=>'David',
            'coordinator_email'=>'David@gamil.com',
            'complexity'=>'hard'
        ]);
        DB::table('projects')->insert([
            'title'=>'The mass fraction of potato rocket Rodeo in the Milky Way',
            'description' => "Step into the world of GalacticPotatoRocketRodeo, where potatoes aren't just for eating. They're interstellar rockets, zooming through space rodeos. It's a universe where spuds are astronauts, and every star is a potential french fry. Join the cosmic tuber journey and explore the galaxy, one potato at a time.",
            'trimester'=> 3,
            'team_size'=>4,
            'year' => 2023,
            'inpID' => 2,
            'coordinator_name'=>'Alice',
            'coordinator_email'=>'Alice1@gamil.com',
            'complexity'=>'hard'
        ]);
        DB::table('projects')->insert([
            'title'=>'Model for calculating the probability of a dancing penguin eating peanut butter at a carnival',
            'description' => "Welcome to DancingPenguinPeanutButterFiesta, the most unexpected party on the planet. Penguins waddle to the rhythm, while jars of peanut butter light up the dance floor. It's a wild, wacky celebration where flightless birds and creamy spreads come together in a dance of delicious delight.",
            'trimester'=> 1,
            'team_size'=>3,
            'year' => 2026,
            'inpID' => 2,
            'coordinator_name'=>'Alice',
            'coordinator_email'=>'Alice1@gamil.com',
            'complexity'=>'moderate'
        ]);
        DB::table('projects')->insert([
            'title'=>'Survival probability of the Mystic Mermaid in the Labyrinth of Mount Shukwai',
            'description' => "Dive deep into the MysticalMermaidMarshmallowMountainMaze. Here, mermaids navigate through mountains made entirely of marshmallows. Every turn is a sugary surprise, every peak a fluffy challenge. It's a labyrinth where sea meets sweet, and every mermaid is on a quest for the ultimate marshmallow treasure.",
            'trimester'=> 2,
            'team_size'=>4,
            'year' => 2026,
            'inpID' => 5,
            'coordinator_name'=>'David',
            'coordinator_email'=>'David@gamil.com',
            'complexity'=>'moderate'
        ]);
        DB::table('projects')->insert([
            'title'=>"Supersonic Pudding's ability when it hits the Smoothie Clowns",
            'description' => "Venture into the realm of SupersonicSlothSmoothieShenanigans, where sloths aren't slow, they're supersonic! Watch them zip around, blending the most exotic smoothies. It's a whirlwind of fruits, flavors, and furry speedsters. Who knew sloths could be this fast... and this thirsty?",
            'trimester'=> 2,
            'team_size'=>3,
            'year' => 2026,
            'inpID' => 2,
            'coordinator_name'=>'Alice',
            'coordinator_email'=>'Alice1@gamil.com',
            'complexity'=>'moderate'
        ]);
        DB::table('projects')->insert([
            'title'=>"Whimsical Walrus Waffle in Waterpark Wonderland",
            'description' => "Welcome to WhimsicalWalrusWaffleWaterparkWonderland, the only place where walruses slide down waffle slides into syrup pools. It's a splashy spectacle of breakfast delights and walrus antics. Grab a floatie, and let these tusked creatures guide you through the sweetest waterpark adventure.",
            'trimester'=> 2,
            'team_size'=>3,
            'year' => 2026,
            'inpID' => 3,
            'coordinator_name'=>'Bobie',
            'coordinator_email'=>'Bob1@gamil.com',
            'complexity'=>'moderate'
        ]);
        DB::table('projects')->insert([
            'title'=>"Image recognition of bison eating popping bubblegum at ballet brigade",
            'description' => "Step into the world of BouncingBubblegumBisonBalletBrigade. Here, majestic bison perform elegant ballets, all while chewing vibrant bubblegum. Each pirouette comes with a pop, each leap with a bubble burst. It's a symphony of dance and gum, where bison grace meets bubblegum pace.",
            'trimester'=> 3,
            'team_size'=>4,
            'year' => 2026,
            'inpID' => 2,
            'coordinator_name'=>'Alice',
            'coordinator_email'=>'Alice1@gamil.com',
            'complexity'=>'moderate'
        ]);


        // Additional 20 projects
        $additionalProjects = [
            ['title' => 'Quantum Computing Basics', 'description' => 'An introduction to the world of quantum computing.', 'trimester' => 1, 'year' => 2025, 'inpID' => 4],
            ['title' => 'AI in Healthcare', 'description' => 'Exploring the applications of artificial intelligence in the medical field.', 'trimester' => 2, 'year' => 2024, 'inpID' => 5],
            ['title' => 'Blockchain Technology', 'description' => 'Understanding the fundamentals of blockchain and its impact on industries.', 'trimester' => 1, 'year' => 2024, 'inpID' => 6],
            ['title' => 'Augmented Reality Development', 'description' => 'Creating immersive AR experiences for various platforms.', 'trimester' => 3, 'year' => 2024, 'inpID' => 7],
            ['title' => 'Deep Learning for Vision', 'description' => 'Implementing deep learning models for computer vision tasks.', 'trimester' => 2, 'year' => 2025, 'inpID' => 4],
            ['title' => 'IoT in Smart Cities', 'description' => 'Designing IoT solutions for urban development and sustainability.', 'trimester' => 1, 'year' => 2024, 'inpID' => 5],
            ['title' => 'Cybersecurity Essentials', 'description' => 'Protecting digital assets and understanding cyber threats.', 'trimester' => 3, 'year' => 2025, 'inpID' => 6],
            ['title' => 'Robotics in Manufacturing', 'description' => 'Leveraging robotics for efficient production and automation.', 'trimester' => 2, 'year' => 2024, 'inpID' => 3],
            ['title' => 'Natural Language Processing', 'description' => 'Building models to understand and generate human language.', 'trimester' => 1, 'year' => 2025, 'inpID' => 4],
            ['title' => 'Virtual Reality in Gaming', 'description' => 'Designing VR games and understanding the technology behind it.', 'trimester' => 3, 'year' => 2024, 'inpID' => 5],
            ['title' => 'Data Analytics with Python', 'description' => 'Using Python for data analysis and visualization.', 'trimester' => 2, 'year' => 2025, 'inpID' => 6],
            ['title' => 'Cloud Computing Fundamentals', 'description' => 'Exploring cloud services and infrastructure.', 'trimester' => 1, 'year' => 2024, 'inpID' => 2],
            ['title' => 'Mobile App Development', 'description' => 'Building mobile applications for Android and iOS.', 'trimester' => 3, 'year' => 2025, 'inpID' => 4],
            ['title' => 'Machine Learning Algorithms', 'description' => 'Understanding and implementing ML algorithms.', 'trimester' => 2, 'year' => 2024, 'inpID' => 5],
            ['title' => 'Web Development with React', 'description' => 'Creating web applications using React.js.', 'trimester' => 1, 'year' => 2024, 'inpID' => 6],
            ['title' => 'Digital Marketing Strategies', 'description' => 'Learning effective online marketing techniques.', 'trimester' => 3, 'year' => 2024, 'inpID' => 7],
            ['title' => 'Database Design and Management', 'description' => 'Designing robust and scalable databases.', 'trimester' => 2, 'year' => 2024, 'inpID' => 4],
            ['title' => 'UX/UI Design Principles', 'description' => 'Designing user-friendly interfaces and experiences.', 'trimester' => 1, 'year' => 2024, 'inpID' => 5],
            ['title' => 'Agile and Scrum Methodologies', 'description' => 'Implementing agile practices in software development.', 'trimester' => 3, 'year' => 2023, 'inpID' => 6]
        ];

        foreach ($additionalProjects as $project) {
            $inpID = $project['inpID'];
            $inp = DB::table('users')->where('is_approved', 1)->orderByRaw('RANDOM()')->first();
            $complexities = ['easy', 'moderate', 'hard'];
            $complexityKey = array_rand($complexities);
            $complexityValue = $complexities[$complexityKey];

            DB::table('projects')->insert([
                'title' => $project['title'],
                'description' => $project['description'],
                'trimester' => $project['trimester'],
                'team_size' => rand(3, 6),
                'year' => $project['year'],
                'inpID' => $inpID,
                'coordinator_name' => $inp->name,
                'coordinator_email' => $inp->email,
                'complexity' => $complexityValue
            ]);
        }
    }
}
