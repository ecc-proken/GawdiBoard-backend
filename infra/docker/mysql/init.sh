flag=true

while $flag; do

  if (docker compose -f ./docker-compose.yml logs | grep "MySQL\sinit\sprocess\sdone.\sReady\sfor\sstart\sup." > /dev/null 2>&1) ; then
    echo "Mysql Ready"
    flag=false
  fi

done