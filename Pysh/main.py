#!/usr/bin/python
import os

black_list = "bcfghijkmnoqstuvwxz!@#|[]{}\"'&*()?01234569"

your_input = raw_input(":")

for i in range(len(black_list)):
    if black_list[i] in your_input:
        print "Bad hacker...."
        exit()

# for admin log
print >> sys.stderr, your_input

print os.system("bash -c '" + your_input + "'")
