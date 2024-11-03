 Fee calculator that - given a monetary amount and a term (the contractual duration of the loan, expressed as a number of months) - will produce an appropriate fee for a loan, based on a fee structure and a set of rules described below. 

 
# Fee Structure
The fee structure doesn't follow particular algorithm and it is possible that same fee will be applicable for different amounts.

### Term 12
```
1000 PLN: 50 PLN
2000 PLN: 90 PLN
3000 PLN: 90 PLN
4000 PLN: 115 PLN
5000 PLN: 100 PLN
6000 PLN: 120 PLN
7000 PLN: 140 PLN
8000 PLN: 160 PLN
9000 PLN: 180 PLN
10000 PLN: 200 PLN
11000 PLN: 220 PLN
12000 PLN: 240 PLN
13000 PLN: 260 PLN
14000 PLN: 280 PLN
15000 PLN: 300 PLN
16000 PLN: 320 PLN
17000 PLN: 340 PLN
18000 PLN: 360 PLN
19000 PLN: 380 PLN
20000 PLN: 400 PLN
```

### Term 24

```
1000 PLN: 70 PLN
2000 PLN: 100 PLN
3000 PLN: 120 PLN
4000 PLN: 160 PLN
5000 PLN: 200 PLN
6000 PLN: 240 PLN
7000 PLN: 280 PLN
8000 PLN: 320 PLN
9000 PLN: 360 PLN
10000 PLN: 400 PLN
11000 PLN: 440 PLN
12000 PLN: 480 PLN
13000 PLN: 520 PLN
14000 PLN: 560 PLN
15000 PLN: 600 PLN
16000 PLN: 640 PLN
17000 PLN: 680 PLN
18000 PLN: 720 PLN
19000 PLN: 760 PLN
20000 PLN: 800 PLN
```

# Usage
To calculate fee run below command: 
```
php bin/console app:calculate-fee {amount} {term}
```
where `{amount}` is the monetary amount and `{term}` is the contractual duration of the loan
