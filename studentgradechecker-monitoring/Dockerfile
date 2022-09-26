FROM --platform=linux/amd64 ubuntu:18.04

RUN apt-get update -y
RUN apt-get install -y python3-pip python-dev

COPY . /app

WORKDIR /app/src

RUN pip3 install flask
RUN pip3 install requests
RUN pip3 install flask-mysql
RUN pip3 install apscheduler

ENTRYPOINT ["python3"]
CMD ["app.py"]
