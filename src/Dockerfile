FROM balenalib/rpi-debian-python:3.9.13
WORKDIR /app
RUN apt-get update
RUN apt-get install -y gcc python3-picamera2 libc-dev libgtkmm-3.0-1v5 libnotify4 libopenblas-dev libopenblas0-pthread libgfortran5 libxcb-cursor0 libxcb-xkb1 libzbar0 libwebpmux3 libopenjp2-7 libwebpdemux2 liblcms2-2 libxrender1 libavformat58 libjbig0 libharfbuzz0b  libopus0 libatlas3-base libdatrie1 libva-drm2 libvorbis0a libsoxr0 libgsm1 libva2 libxcb-render0 librsvg2-2 libgdk-pixbuf2.0-0 libtwolame0 libxfixes3 libzvbi0 libwebpmux3 libssh-gcrypt-4 libopenjp2-7 libvorbisenc2  libgraphite2-3 libshine3 libmpg123-0 libva-x11-2 libaom0 libpixman-1-0 libgme0 libvorbisfile3 libmp3lame0 libchromaprint1 libspeex1 libwavpack1 libswscale5 libavcodec58 libtiff5 libogg0 libswresample3 libavutil56 libpangocairo-1.0-0 libwebp6 libgfortran5 libcairo2 libxcb-shm0 libbluray2 libpango-1.0-0 libdrm2 libxvidcore4 libopenmpt0 libpangoft2-1.0-0 libthai0 libtheora0 libfontconfig1 libvdpau1 libsnappy1v5
RUN pip3 install --upgrade pip -vvv
RUN echo '[global] \
extra-index-url=https://www.piwheels.org/simple' >> /etc/pip.conf
COPY . . 
RUN pip3 install -r requirements.txt -i https://www.piwheels.org/simple
WORKDIR /app/SPI-Py
RUN python3 setup.py install
WORKDIR /app
#RUN apt-get install python3-pyqt5 -y
#RUN apt-get install python3-opengl -y
CMD ["python3", "test.py"]
 