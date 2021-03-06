<?php

use App\Traits\QuestionsTrait;

class MyFaker
{
    use QuestionsTrait;
    public function render($faker)
    {
        return $this->to_render($faker);
    }
    /**
     * "[\r\n\t{\r\n\t\t\"type\": \"checkbox\",\r\n\t\t\"label\": \"Checkbox\",\r\n\t\t\"className\": \"checkbox\",\r\n\t\t\"name\": \"checkbox-1478449196912\"\r\n\t}\r\n]"
     */
    public function ans()
    {
        $faker = Faker\Factory::create();
        $count = $faker->randomDigitNotNull;
        $return = "\r\n";
        $tab = "\t";

        $inputs = [];
        $type = $faker->randomElement($array = array('checkbox', 'radio', 'text', 'number'));
        for ($i = 1; $i <= $count; $i++) {

            $n = $faker->words(3, true);
            $label = ucfirst($n);
            $name = str_slug($n) . '-' . $faker->randomNumber($nbDigits = 9);
            $inputs[$i]['type'] = $type;
            $inputs[$i]['label'] = $label;
            $inputs[$i]['className'] = "";
        }

        return json_encode(array_values($inputs), JSON_PRETTY_PRINT);
    }
}

$myfaker = new MyFaker();

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
 */

$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;
    $date = $faker->dateTimeThisMonth($max = 'now');
    $name = $faker->name;
    $username = preg_replace('/[_\-]+/', '', snake_case($name));
    return [
        'name' => $name,
        'username' => $username,
        'email' => $faker->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
        'created_at' => $date,
        'updated_at' => $date,
    ];
});

/**
 * Factory Model for Projects
 */

$factory->define(App\Models\Project::class, function (Faker\Generator $faker) {
    $date = $faker->dateTimeThisMonth($max = 'now');
    $project = $faker->words($nb = 3, $asText = true) . ' Project';
    $short_project_name = substr($project, 0, 10);
    $unique = uniqid();
    $short_unique = substr($unique, 0, 5);
    $dbname = snake_case($short_project_name . '_' . $short_unique);
    return [
        'project' => $project,
        'unique_code' => strtoupper($faker->unique()->randomLetter),
        'dbname' => $dbname,
        'dblink' => $faker->randomElement(['voter', 'enumerator']),
        'type' => $faker->randomElement(['sample2db', 'db2sample']),
        'samples' => [
            "Country" => "1",
            "Region" => "2",
        ],
        'created_at' => $date,
        'updated_at' => $date,
    ];
});

/**
 * Factory Model for Sections
 */
$factory->define(App\Models\Section::class, function (Faker\Generator $faker) {
    return [
        'sectionname' => $faker->text,
        'descriptions' => $faker->text,
        'sort' => $faker->unique()->numberBetween(1, 99),
        'project_id' => function () {
            return factory(App\Models\Project::class)->create()->id;
        },
    ];
});

/**
 * Factory Model for Questions
 */
$factory->define(App\Models\Question::class, function (Faker\Generator $faker) use ($myfaker) {

    $raw_ans = $myfaker->ans();

    /**
     * run closure function to get project id
     */

    $layout = '';

    $section = $faker->numberBetween($min = 1, $max = 5);
    $qnum = $faker->unique()->regexify('[A-Z][A-Z]');

    $question = [
        'qnum' => $qnum,
        'question' => $faker->realText($maxNbChars = 100, $indexSize = 5) . '?',
        'raw_ans' => $raw_ans,
        'layout' => $layout,
        'section' => $section,
        'sort' => $faker->numberBetween(1, 99),
        'project_id' => function () {
            return factory(App\Models\Project::class)->create()->id;
        },
    ];
    $question['css_id'] = str_slug('s' . $section . $qnum);
    return $question;
}, 'question');

/**
 * Factory Model for Voters
 */

$factory->define(App\Models\Voter::class, function (Faker\Generator $faker) {
    $date = $faker->dateTimeThisMonth($max = 'now');
    $nrc = $faker->regexify('[1-9]{1,2}');
    $nrc .= '/';
    $nrc .= $faker->regexify('[a-z]{3}');
    $nrc .= '(နိုင်)';
    $nrc .= $faker->regexify('[0-9]{6}');
    $en_my = [
        'a' => 'က', 'b' => 'စ', 'c' => 'ဋ', 'd' => 'တ', 'e' => 'ပ', 'f' => 'ရ', 'g' => 'ဟ', 'h' => 'ခ', 'i' => 'ဆ', 'j' => 'ဌ', 'k' => 'ထ', 'l' => 'ဖ', 'm' => 'ယ', 'n' => 'ဂ', 'o' => 'ဇ', 'p' => 'ဍ',
        'q' => 'ဒ', 'r' => 'ဗ', 's' => 'လ', 't' => 'သ', 'u' => 'င', 'v' => 'ည', 'w' => 'ဏ', 'x' => 'န', 'y' => 'ဘ', 'z' => 'မ', '0' => '၀', '1' => '၁', '2' => '၂', '3' => '၃', '4' => '၄', '5' => '၅', '6' => '၆', '7' => '၇', '8' => '၈', '9' => '၉',
    ];
    $nrc = strtr($nrc, $en_my);
    return [
        'name' => $faker->name,
        'dob' => $faker->date($format = 'Y-m-d H:i:s', $max = '2000-01-01'),
        'gender' => $faker->randomElement(['male', 'female', 'other']),
        'nrc_id' => $nrc,
        'father' => $faker->name('male'),
        'mother' => $faker->name('female'),
        'address' => $faker->address,
    ];
});
