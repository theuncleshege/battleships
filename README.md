# BattleShips

A simple implementation of the [BattleShips](<https://en.wikipedia.org/wiki/Battleship_(game)>) game in PHP.

## Requirements

- php: >= 7.4
- composer: >= 1.10

## How to run

- `composer install`
- `php index.php`

## Running tests

- `vendor/bin/phpunit` # (Runs all tests)
- `vendor/bin/phpunit --coverage-html coverage` # (Runs all tests and generates coverage reports in html format)

&nbsp;

---

# About the game

A simple php console application to allow a single human player to play a one-sided game of battleships against the computer. The program should create a 10x10 grid, and place a number of ships
on the grid at random with the following sizes:

- 1 x Battleship (5 squares)
- 2 x Destroyers (4 squares)

Ships can touch, but they must not overlap. The application should accept input from the user in the format `A5` to signify a square to target, and feedback to the user whether the shot was success, miss, and additionally report on the sinking of any vessels.

- `.` = no shot
- `-` = miss
- `X` = hit

Example output:

```
  1  2  3  4  5  6  7  8  9  10
A .  .  .  .  .  .  .  .  .  .
B .  .  .  .  .  .  .  .  .  .
C .  .  .  .  .  .  .  .  .  .
D .  .  .  .  .  .  .  .  .  .
E .  .  .  .  .  .  .  .  .  .
F .  .  .  .  .  .  .  .  .  .
G .  .  .  .  .  .  .  .  .  .
H .  .  .  .  .  .  .  .  .  .
I .  .  .  .  .  .  .  .  .  .
J .  .  .  .  .  .  .  .  .  .

Enter coordinates (row, col), e.g. A5 =

```

A `show` command should also be implemented to aid debugging and backdoor cheat. Example output after entering `show`:

```
Enter coordinates (row, col), e.g. A5 = show

  1  2  3  4  5  6  7  8  9  10
A X
B X
C X
D X
E X
F
G                   X
H                   X  X
I                      X
J

Enter coordinates (row, col), e.g. A5 =

```

The application should also report the number of shots taken once game is complete. For example:

```
Enter coordinates (row, col), e.g. A5 = H8
Sunk

  1  2  3  4  5  6  7  8  9  10
A X  .  .  .  .  .  .  .  .  -
B X  .  -  .  .  .  .  .  .  .
C X  .  .  .  .  .  .  .  .  .
D X  .  .  .  .  .  .  .  .  .
E X  .  .  .  .  .  .  .  .  .
F .  .  .  .  .  .  .  .  .  .
G .  .  .  .  .  .  X  -  .  .
H .  .  .  .  .  .  X  X  .  .
I .  .  .  .  .  .  .  X  -  .
J -  .  .  .  .  .  .  -  .  -

Well done! You completed the game in 17 shots
```

Enjoy :v:
