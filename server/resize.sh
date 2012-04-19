#!/bin/bash

# convert --version
# convert --help

SIZE=500x600

DIR=$(dirname $1)
FN=$(basename $1)

DST1=${DIR}/b-$FN
# echo $SIZE "resizing " $1 " to " $DST1
convert $VERBOSE -resize $SIZE $1 $DST1
