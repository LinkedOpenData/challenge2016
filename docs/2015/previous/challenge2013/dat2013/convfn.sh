#!/usr/local/bin/bash

if [ $# -lt 2 ]; then
    echo "Usage: $0 {-w|-e|-s} file" 1>&2
    echo "       -w: UTF8  -e: EUC  -s: Shift_Jis" 1>&2
    exit 0;
fi

for target in ${@:2};
do
    find ${target} -maxdepth 1 -type f | while read line
    do src=`echo ${line}` ;
      dest=`echo ${line} | nkf $1` ;
      if [ "${src}" = "${dest}" ];
      then
          echo "SKIP ${src}" ;
      else
          mv "${src}" "${dest}";
          echo "RENAME \"${src}\" TO \"${dest}\"";
      fi ;
    done
done

