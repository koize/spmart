FROM python:latest

WORKDIR /app

RUN <<EOF
apt-get update
apt-get install python3-opencv
apt-get install libqt5gui5 libqt5webkit5 libqt5test5 python3-sip python3-pyqt5 libatlas-base-dev libjasper-dev 
pip3 install opencv-contrib-python
EOF

COPY . .
CMD ["python3", "main.py"]
