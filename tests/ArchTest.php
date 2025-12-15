<?php

<<<<<<< HEAD
=======
declare(strict_types=1);

>>>>>>> v4
it('will not use debugging functions')
    ->expect(['dd', 'dump', 'ray'])
    ->each->not->toBeUsed();
