#/bin/sh
###########################################################################################
#
#
# MySQL Backup Script By JAEHO SONG. Refer Google Drive
#
#
# https://docs.google.com/a/withcenter.com/document/d/1fX_YXUlNwBfBzAakR_ho8u2H6pXAoHgYUKKqJ2lwa-o/edit#heading=h.kshthsu5s1gg
#
#
###########################################################################################



# Settings 
user="root"
password="ontue0458934377"
tables="philgo cafe cafe_member config member memo post_config post_data"
tables="sap_frame sf_block sf_data sf_config sf_message"


###################################################
n=`eval date +%w`
if [ "$n" -eq 3 ]; then
	d=`eval date +%Y_%m`
	today="last_week_of_$d"
else
	today=`eval date +%A`
fi

basedir="/backup/mysql/dump/"
dir_dst="$basedir/$today"



if [ -d $dir_dst ]; then
	rm -f "$dir_dst/*"
else
	mkdir -p $dir_dst
fi

chmod 777 $dir_dst

mysqldump -u$user -p$password --tab=$dir_dst $tables

chmod -R 600 $dir_dst
