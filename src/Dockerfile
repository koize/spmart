FROM arm32v7/python:3.7-slim-buster
WORKDIR /app
RUN apt-get update && apt-get install -y gcc libxrender1 libavformat58 libjbig0 libcodec2-0.8.1 libharfbuzz0b libvpx5 libopus0 libatlas3-base libdatrie1 libva-drm2 libvorbis0a libsoxr0 libgsm1 libva2 libxcb-render0 librsvg2-2 libgdk-pixbuf2.0-0 libtwolame0 libxfixes3 libzvbi0 libwebpmux3 libssh-gcrypt-4 libopenjp2-7 libvorbisenc2 libx265-165 libgraphite2-3 libshine3 libmpg123-0 libva-x11-2 libaom0 libpixman-1-0 libgme0 libvorbisfile3 libmp3lame0 libchromaprint1 libspeex1 libwavpack1 libswscale5 libavcodec58 libtiff5 libogg0 libswresample3 libavutil56 libpangocairo-1.0-0 libwebp6 libgfortran5 libcairo2 libxcb-shm0 libx264-155 libbluray2 libcroco3 libpango-1.0-0 libdrm2 libxvidcore4 libopenmpt0 libpangoft2-1.0-0 libthai0 libtheora0 libfontconfig1 libvdpau1 libsnappy1v5
RUN pip3 install --upgrade pip -vvv
RUN pip3 install opencv-python-headless -vvv -i https://www.piwheels.org/simple
RUN pip3 install --no-cache-dir rpi.gpio -vvv -i https://www.piwheels.org/simple
RUN pip3 install smbus -vvv -i https://www.piwheels.org/simple
RUN pip3 install python3-spi -vvv -i https://www.piwheels.org/simple
RUN pip3 install spi -vvv -i https://www.piwheels.org/simple
RUN pip3 install spidev2 -vvv -i https://www.piwheels.org/simple
RUN pip3 install pyzbar -vvv -i https://www.piwheels.org/simple

COPY . .
WORKDIR /app/SPI-Py
RUN python3 setup.py install
WORKDIR /app
CMD ["python3", "main.py"]
 