FROM --platform=linux/amd64 ubuntu:18.04

RUN apt-get update -y && apt-get install -y  python3-pip python3
RUN apt-get install -y python3-markupsafe

COPY ./requirements.txt /app/requirements.txt
WORKDIR /app
RUN pip3 install requests
RUN pip3 install -r requirements.txt

COPY ./src /app

EXPOSE 5000

ENTRYPOINT ["python3"]
CMD ["proxy.py"]
