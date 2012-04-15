#!/bin/bash

# convert --version
# convert --help

SIZE=500x600
THR=50%
EDGE=2
VERB=-v
VERBOSE=-verbose
# VERB=
# VERBOSE=

DIR=$(dirname $1)
FN=$(basename $1)

TM=`date +%s`

DST1=${DIR}/res_$FN
# echo $SIZE "resizing " $1 " to " $DST1
convert $VERBOSE -resize $SIZE $1 $DST1

# ls -l $DST1

DST2=${DIR}/col_$FN
# echo "threshold " $THR " monochrome " $DST1 " to " $DST2
convert $VERBOSE -monochrome -threshold $THR -blur 10 $DST1 $DST2
# ls -l $DST2

DST3=${DIR}/edg_$FN
# echo $EDGE "edge " $DST2 " to " $DST3
convert $VERBOSE -edge $EDGE $DST2 $DST3
rm $VERB $DST2
rm $VERB $DST1

mv $VERB $DST3 $DIR/b-$FN
