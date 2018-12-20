#!/usr/bin/env python

import sys

def score(text):
    charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789,.'\n"
    p = 0
    for s in text:
        if s in charset or s == ' ' or s == '\'':
         p+=1
    return p

# function that performs XOR operation on two strings
def xor(s1, s2):
    res = ""
    for i in range(0, len(s1)):
        res += chr(ord(s1[i]) ^ ord(s2[i%len(s2)]))

    return res

def main():
    best = ""
    b = 0

    # bruteforcing all possible values
    for i in range(1, 256):
        c = xor(sys.argv[1].decode('hex'), chr(i))
        if score(c) > b:
            b = score(c)
            best = c

    print "Plaintext: {}".format(best)

if __name__ == "__main__":
    main()