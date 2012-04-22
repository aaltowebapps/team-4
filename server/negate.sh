#!/bin/bash

DST=`mktemp negateXXXX --tmpdir`

convert -negate $1 $DST
mv $DST $1
