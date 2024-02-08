FROM balenalib/rpi-debian-python:3.9.13
WORKDIR /app
RUN apt-get update && apt-get install -y gcc python3-picamera2 libzbar0 libwebpmux3 libopenjp2-7 libwebpdemux2 liblcms2-2 libxrender1 libavformat58 libjbig0 libharfbuzz0b  libopus0 libatlas3-base libdatrie1 libva-drm2 libvorbis0a libsoxr0 libgsm1 libva2 libxcb-render0 librsvg2-2 libgdk-pixbuf2.0-0 libtwolame0 libxfixes3 libzvbi0 libwebpmux3 libssh-gcrypt-4 libopenjp2-7 libvorbisenc2  libgraphite2-3 libshine3 libmpg123-0 libva-x11-2 libaom0 libpixman-1-0 libgme0 libvorbisfile3 libmp3lame0 libchromaprint1 libspeex1 libwavpack1 libswscale5 libavcodec58 libtiff5 libogg0 libswresample3 libavutil56 libpangocairo-1.0-0 libwebp6 libgfortran5 libcairo2 libxcb-shm0 libbluray2 libpango-1.0-0 libdrm2 libxvidcore4 libopenmpt0 libpangoft2-1.0-0 libthai0 libtheora0 libfontconfig1 libvdpau1 libsnappy1v5
RUN apt-get install -y libc-dev libgtkmm-3.0-1v5 libnotify4 libopenblas-dev libopenblas0-pthread libgfortran5
RUN pip3 install --upgrade pip -vvv
RUN pip3 install ninja==1.11.1 -vvv -i https://www.piwheels.org/simple
RUN pip3 install numpy==1.26.4 -vvv -i https://www.piwheels.org/simple
RUN pip3 install opencv-python -vvv -i https://www.piwheels.org/simple
RUN pip3 install --no-cache-dir rpi.gpio -vvv -i https://www.piwheels.org/simple
RUN pip3 install smbus -vvv -i https://www.piwheels.org/simple
#RUN pip3 install python3-spi -vvv -i https://www.piwheels.org/simple
#RUN pip3 install spi -vvv -i https://www.piwheels.org/simple
#RUN pip3 install spidev2 -vvv -i https://www.piwheels.org/simple
RUN pip3 install zbar-py -vvv -i https://www.piwheels.org/simple
RUN pip3 install pillow -vvv -i https://www.piwheels.org/simple
RUN pip3 install pyzbar-upright[scripts] -vvv 
RUN pip3 install mysql-connector-python -vvv -i https://www.piwheels.org/simple
COPY . .
WORKDIR /app/SPI-Py
RUN python3 setup.py install
WORKDIR /app
CMD ["python3", "main.py"]
 