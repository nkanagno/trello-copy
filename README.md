# Run the website 
## Install Docker Desktop:
### Windows 10/11 and macOS
If you haven't installed Docker Desktop, you can download it from the [Docker website](https://docs.docker.com/desktop/install/windows-install/).

## run docker-compose
run:
```
docker-compose up
```
## if you change a mysql
to see all images
```
docker ps -a
```

### stop docker container

docker stop CONTAINER ID
example:
```
docker stop 63dfa03f5446 
```

### remove docker
example:
```
docker rm 63dfa03f5446
```


delete docker compose from the docker app

rerun 
```
docker-compose up
```
