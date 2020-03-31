<?php

namespace Tests\Feature\App\Support;

use App\Support\Str;
use Illuminate\Support\Facades\Config;
use Tests\TestCase;

class StrTest extends TestCase
{

    public function testNanoId()
    {
        Config::set('app.nanoid.alphabet', '123456789');
        Config::set('app.nanoid.length', 10);
        $nanoId = Str::nanoId();
        $this->assertEquals(strlen($nanoId), 10);
        $this->assertTrue((bool) preg_match('/[0-9]+/', $nanoId));

        Config::set('app.nanoid.alphabet', 'abcdefghijklmnopqrstuvwxyz');
        $nanoId = Str::nanoId();
        $this->assertEquals(strlen($nanoId), 10);
        $this->assertTrue((bool) preg_match('/[a-z]+/', $nanoId));
    }

    public function testGeneratePassword()
    {
        $options = [
            'file_path' => \Illuminate\Support\Facades\App::resourcePath('dictionary.txt'),
            'words' => 4,
            'delimiter' => '-',
            'min_char_length' => 5,
        ];
        $password = Str::generatePassword($options);
        $parts = explode($options['delimiter'], $password);
        $this->assertEquals(count($parts), $options['words']);
        foreach ($parts as $word) {
            $this->assertGreaterThanOrEqual($options['min_char_length'], strlen($word));
        }
    }

    public function testInitials()
    {
        $name = 'Joe Bloggs';
        $this->assertEquals(Str::initials($name), 'JB');
        $name = 'Joe With A Few Middle Names Bloggs';
        $this->assertEquals(Str::initials($name), 'JB');
        $name = 'OneWord';
        $this->assertEquals(Str::initials($name), 'OW');
        $name = 'Onewordname';
        $this->assertEquals(Str::initials($name), 'ON');
        $name = 'ÒneÀscii';
        $this->assertEquals(Str::initials($name), 'OA');
    }

    public function testHexColor()
    {
        $str = 'hello world';
        $this->assertEquals(Str::hexColor($str), '5eb63b');
        $str = 'another test string';
        $this->assertEquals(Str::hexColor($str), 'c1544d');
    }
}
