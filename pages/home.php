<?php  require(getenv("DOCUMENT_ROOT")."/functions/database.php");
		if ($_SESSION[ERROR] != "")
		{	
			echo "<div class='alert alert-success fade in text-center' data-dismiss='alert' role='alert'>
			<button type='button' class='close' data-dismiss='alert'>×</button>
			$_SESSION[ERROR]
			</div>";
			$_SESSION[ERROR] ="";
		}
$defimg = 'data:image/jpeg;base64,/9j/4AAQSkZJRgABAQEAYABgAAD/2wBDAAIBAQIBAQICAgICAgICAwUDAwMDAwYEBAMFBwYHBwcGBwcICQsJCAgKCAcHCg0KCgsMDAwMBwkODw0MDgsMDAz/2wBDAQICAgMDAwYDAwYMCAcIDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAz/wAARCAFeAlADASIAAhEBAxEB/8QAHwAAAQUBAQEBAQEAAAAAAAAAAAECAwQFBgcICQoL/8QAtRAAAgEDAwIEAwUFBAQAAAF9AQIDAAQRBRIhMUEGE1FhByJxFDKBkaEII0KxwRVS0fAkM2JyggkKFhcYGRolJicoKSo0NTY3ODk6Q0RFRkdISUpTVFVWV1hZWmNkZWZnaGlqc3R1dnd4eXqDhIWGh4iJipKTlJWWl5iZmqKjpKWmp6ipqrKztLW2t7i5usLDxMXGx8jJytLT1NXW19jZ2uHi4+Tl5ufo6erx8vP09fb3+Pn6/8QAHwEAAwEBAQEBAQEBAQAAAAAAAAECAwQFBgcICQoL/8QAtREAAgECBAQDBAcFBAQAAQJ3AAECAxEEBSExBhJBUQdhcRMiMoEIFEKRobHBCSMzUvAVYnLRChYkNOEl8RcYGRomJygpKjU2Nzg5OkNERUZHSElKU1RVVldYWVpjZGVmZ2hpanN0dXZ3eHl6goOEhYaHiImKkpOUlZaXmJmaoqOkpaanqKmqsrO0tba3uLm6wsPExcbHyMnK0tPU1dbX2Nna4uPk5ebn6Onq8vP09fb3+Pn6/9oADAMBAAIRAxEAPwD95KKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiijHOPw/l/iPzoAKAMmuT8dfG/wAL/D26+z6lqluLvvawBpp/+BImWX8RXKyfteaEX2rovieZP732WJR/3y0uaAPVhzRXAeHf2lvC+v3CxzTXWlyueBfwGNT9XGYx+dd7DMtzFHJGyyJIu5GU5Dj1B7igB1FFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABXlP7Unj3V/DWm6RpGjTtYy64ZhPdqv7yGGPbuVD0DNvHJ6bT6V6tWD4++HOn/ABF0yK3vlaOS3YyQSx8SQse+ffaMj3oA+XNL0W10WPbGv7xvvu5zI3/Aua1YtKupIvMjtZnT+8IyR+de6eDvgPpPhi4M8zSanMv3fP8A9Wn4dTXcRRbI1jUKox0AGP5UAfJTKrDawVsHByOhrvfgH48m8N69DpM8jNpuokKilifIlPQjPOD6U79p6Oz0vxxoYt1iW6v7ed7oIu0kJt8tvQbsnnvg1xugNIut2UkeQ63EbL9Q1AH1RRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAVPEOuw+HNAvtQuNzW1jbyXEoVfmYIuTivn68/aY8ZeJrZpLG10XQ7e45jLRvczqv1Ztuf+A19Ba5pS69oV5YuPkvoHgbPo4wa+T9G0y8hjisZreVL+ICGSIqQ4Ye3XNACLBcXer3GpX19calqVwP3l1Mctt9AOiivQfgf8PpvE3ieDUpY2WwsXEwcjiVh90D198V3XhL9n3R9Ot7ebUFmvLjYGkjlb92jemB1rvLa3Wyh8uFVhiHRIwABQBJRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUARajqEOlWc1zcTR29vbqXklkcJHGo6lieAB6mvOLX9pzwRfayvltdNh9ovvsD+Sx9c43Y96m/aos7i++D15Hbq/lNcQfath+YweZ834evovNeHpCkEYjXy1VR0C8UAfWVrdR31tHNDJHNDMu5HRgyuPUEcEVJXH/AAHiuLf4aWSzblDM5i3dVjz8tdhQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFG6jdQAyeBbiBopVEkbqQ0bYZWHoa5iP4J+F47zzl0pFb+6ZXMf8A3xuxXVbqN1ACRRrDGFRdqgABFwqqPQUtG6jdQAUUbqM0AFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAVR8QeJ9O8K2f2nUr6z0+33bfNuZ1hTPpliBmrx4/z/n0r5M8a+IW+KvxA1DWLqQ3VhDM9vpcTMTDFAvyggDglzzk9KAPon/hefg3/oatB/8AAyL/AOKo/wCF5+Df+hq0H/wMi/8Aiq+cPsUP/PGH/vgUv2GH/njD/wB8CgD6O/4Xn4N/6GrQf/AyL/4qj/hefg3/AKGrQf8AwMi/+Kr5x+ww/wDPGH/vgUfYYf8AnjD/AN8CgD6O/wCF5+Df+hq0H/wMi/8AiqP+F5+Df+hq0H/wMi/+Kr5x+ww/88Yf++BR9hh/54w/98CgD6O/4Xn4N/6GrQf/AAMi/wDiq2PDvjPSfFkLS6Tqmn6ikJw/2adJtn12k4r5Z+ww/wDPGH/vgVe8LatL4S1+11Gy/cS2zqcIdu9R1Vh0OfWgD6qPB+tFRWF4moWMNxFJuhmRXU9evIqWgAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKM4/T9elABRR3oBzQAUUUH5etAHHfHrxg3gX4U6veQttu5oza2vPPmzfIpH+7kt7AE186aNYLpemw246ImPpXY/tB/FC1+Jviix0fSZPtWmaJMbi5uUO6O4n27VRSOCoUk5HeuWoAKKKKACiiigAooooAKKKKAPff2f/EP9ueAo4C2+bTZGgbJ5K9V/Tiu3r58+C/xCg8C+I3W+bbYX6CGR9pby2H3Xx6epr6BguI7qBZInWSOT7rqdyt9DQA6iiigAooPy9eKM80AFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAVyvxV+Lml/CTREuLsyT3VwTHa2cI/e3Ug6hfRV7noK6qvln4kavJ4z+MOvahPmSPTbhtLtEY/LEsR2sQPVm6mgC9rXxw8beLpWY6hH4ftW+7bWSrJJ/wACkZST+FZR8ReIm/5mrxI3/b/IKgooAsf8JJ4g/wCho8Sf+DGSq2qXuqa9YtaX2v8AiC8tJF/eQy30nlt/vDI3fiRS0UAR2lpDZWyxQRiNEJIHofXPepKKP8cUAA+aitLw14R1DxnqBt7G386X+Njwkf1Pb8a9W8J/s3WNiqyatM17N/cjOyP8/vUAeL98d/SlCk9jX1Bp3gvSdGiVbTTbKH3WIE/rWnsCp90fp/hQB8ljk0Ywa+pNT8J6XraYu9Psbhf+mkAJrivFX7N+k6lGz6ZJJp0n9wnzIf8Avk80AeIdRRWt4x8Eal4FvfI1C3WNWOI5lOY5D6Keg/Gsk8fyoAGAdKktNS1LTLfy7DWNY02M9Yre7dIz/wABBAFR0UAWP+Ej8Qf9DR4l/wDBjJR/wkfiD/oaPEn/AIMZKk0Xw5feJJzHp9ncXkkf3wkZbb9cDim6tot54fuPKvbWazlIyokQr5g9s9fwoA1vDvxd8WeGZl8vWpNQgXrBfxrKp/4GNr/+PV7R8Lvi3Z/Ei2aPy3stShXfLbOwYY9UP8Q9xXzv1rR8Ja/J4X8R2d9EzL9nlUsB/HH/ABLQB9R0UUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABXybqP/ACOHib/sOX3/AKUtX1lXydqf/I4+Jv8AsO3/AP6PegBlFFFABRRRQAV0Xw4+Hd18Q9ZEce6O0gwbifH+rB6Aere1Yen2M2qX0VrAu64uZFjUAZyfSvpbwL4Nt/BPh23sYVG6NQ8sg6yv3/AdqALHhnwxY+EdNSzsbdYoYwM8fNJ9WrQzQOfyz+FcP8X/AI8aZ8J0W3aNtU1q6UtDYQuAxXs7n+BT2J4oA7gnFBOK+XfEHxR8ZeOHZr7XJtItv4bTSm+zhP8AgfLn/vqsP+y8SbvteotJ/ea8kLf99bs0AfX2Dz7dfagnFfMHh34h+IvCTo1lrV7NGvW3vXN1Efpvyy/8AZa9l+FvxvtPHDLY3kS6dq+MiINujuPeNv73tQB2Wr6Pa69pr2t5DFcW8o2srL09x3Br58+KfwuuPhpqyMu6bSrokW85HKk9Eb3NfRZ4qj4n8N2vi/Q7rTb5N9vdIVbHVT2ZT2IoA+WSMUVY1jRrjw1rd5pt1/x8WMpiJx/rB1Vh7Hse9V6APoj4L6Xa6f8ADjTnt1VTcJvmfHzM/pmsz9pWztR8J9QvZhGtxYSRvDJj5kcyIu0eoOT+Rry7wb8XNa+H9q0FmlrdWjEsbafKiP8A3COn41lfEL4ga98Wrm2j1ZrWz0u1kE0dlagkSSAcGR25bDc4oAz0JpaKKAPrSiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAK+TtT/wCRx8Tf9h2//wDR719Y18nan/yOPib/ALDt/wD+j3oAZRRRQAUUUUAehfs5+Gl1TxbJfOu6PT4sjI/5aH7v8jXuVeb/ALNFmsPhC9uP457vyyfZVH/xVekUAc58WfiLD8L/AAJeatKBLJCBHbQ9PtE7cIn/AH1zj+7z0r5jsYbq8vLjUtUla81TUHMtxK3PzHsv91R2Fen/ALW+pte+IvC+kbswoJr+dezFSqp+WT+RrzugAooooAKEd4pFkRmjljO5ZEOGX6UUUAfRnwi8d/8ACe+E1luP+P8Asz5Nwq9z2b8fWuorw/8AZq1hrXxldWm4+VdW5Yr6shyP0r3CgDxX9qLw79g1vSdbX5ReBrCfA6sMtE312g/ka81r3H9qKzW5+EN1cfx2NzbzofQmYIf/AB2QivDs0AFFFFABRRRQB9aUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABXydqf/ACOPib/sO3//AKPevrGvk7U/+Rx8Tf8AYdv/AP0e9ADKKKKACiiigD3H9mqdZPA10v8AcvWOP+ArXodeO/sza/5Gq6lpjEbriNZoxnjK8NXsWc0AeF/tT6a0fj3w/dbTtms54OnQo6n9cn8jXn+a99+PXgGTxp4KP2WMvfaXL9rt0XlpMfKyD1yvOPWvAIZPOi3DlSM5oAdRRRQAUUUZyPx2/j6UAd5+znZNc/EDzADtt7aRmOOOu2veK8+/Z78FSaF4akvrlGW41LbtBGCkQ4X8zya9BoA8/wD2o7lbf4JawOhmltkUfW5iNeFL92vUf2vNeVtO8P6GjfvL69N5IAf+WUKnr7Fip/4D7V5fQAUUUUAFFFFAH1pRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFfJ2p/8jj4m/wCw7f8A/o96+sa+TtT/AORx8Tf9h2//APR70AMooooAKKKKANLwh4kk8I+JLPUIs77WQFgP407g/WvpvStWh1vTILq1kE0NwqvGfr2NfKVd/wDBT4tL4Ouf7M1CRv7NnbMbk/8AHq568/3T69qAPdR8xryf4tfAZry8m1XQY0aSZmkubQ/LuJ6uh6Z9VHXtXrCsHVWU7lbkEd6Mdf8AZ6+1AHyfd2sthctDPHJDNH96ORSrL9QeajzivqTWfDGm+IY8X1la3W3+KSPcy/7p/wAaxW+CPhcv/wAgmPd/12fH/oVAHzvDC9xJtjVpGPQKMk16d8L/AIDz3NzHfa5H5FvHgx2rD5pP94dh7HmvUtE8HaX4cA+w2Frasv8AGifN+f3v0rSx82O/TFAAqKkeNq7VAAVeAB6CmzTpbwvJI6xxxqWdmOFUDqSewFOzXgn7RXxl/wCEvupvCOhzF7Vfk1e8jbjA6QRsOD/tEdO9AHG+LfGbfFD4i6hr/wA32FcWenhuogTq+P8Aab589+lQU2C3S2hVI1CRoNqqO1OoAKKKKACiiigD60ooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACvk7U+PGPib/ALDt/wD+j3r6xr5U8RWTaZ478TQSff8A7YupMHriSRnU/THP0oArUUUUAFFFFABQwDo1FFAHXfDr4y6l8PUS3kRtS0kYAgZ/3kA9Yien+6fl969m8G/E/Q/Hsaf2bfRtP/z7Sfu5k/4CeTXzXUd3Zw3p/eLub+8R835gigD647UHg18uab468TaEm2x8SapCnpOyXS/lIrGr/wDwu7xwBga5b59Tp8f+NAH0oeBntWH4z+JGh/DuyabWtUtbBeqxO5Msx/2I1+ZvwFfOuq/EHxhrq4vPFmprH6WqpbH/AL6jVW/SsO18P2tvdtcMjzXDt8800hllP/Aj/QUAdp8SP2g9a+Jkcmn6Ilz4f0Z8rLdO2L25H+zj/VL7DmuS03ToNJslgt0WONcsQATuPck9STU4Py7eF+gooAKKKKACiiigAozRU1hayX95HbouXuHCAAc89PzoA+rqKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAryL9oP4XzXWo/8JDpsckzSRrFewoMs+D8soA5zt4Neu0H5lKtu5BUg4INAHyWrb13L8yjqRRX0V4j+C/h/xNcNNJava3DH/WWpCfp0rG/4Zn0H/n81j/v7H/8AEUAeHUV7j/wzPoP/AD+ax/39j/8AiKP+GZ9B/wCfzWP+/sf/AMRQB4dRXuP/AAzPoP8Az+ax/wB/Y/8A4ij/AIZn0H/n81j/AL+x/wDxFAHh1Fe4/wDDM+g/8/msf9/Y/wD4ij/hmfQf+fzWP+/sf/xFAHh1Fe4/8Mz6D/z+ax/39j/+Io/4Zn0H/n81j/v7H/8AEUAeHUV7j/wzPoP/AD+ax/39j/8AiKP+GZ9B/wCfzWP+/sf/AMRQB4dRXuP/AAzPoP8Az+ax/wB/Y/8A4ij/AIZn0H/n81j/AL+x/wDxFAHh1Fe4/wDDM+g/8/msf9/Y/wD4ij/hmfQf+fzWP+/sf/xFAHh1Fe4/8Mz6D/z+ax/39j/+Io/4Zn0H/n81j/v7H/8AEUAeHfxY7noPWvTPgN8NJb7U4davIdtrasDbo4wZX7HnqB6122g/Arw/4fnEn2d7tl6G5beP++VwtdjGnlqoVQu35e21R7AUALRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQAUUUUAFFFFABRRRQB//9k=';		
?>		
<!---->
<div class="banner">
	 <div class="container">
	 </div>
</div>
<!---->
<div class="welcome">
	 <div class="container">
		 <div class="col-md-3 welcome-left">
			 <h2>Welkom bij Vaporama</h2>
		 </div>
		 <div class="col-md-9 welcome-right">
			 <h3>Vaporama , een nieuwe Wereld</h3>
			 <p>Wij bij Vaporama zijn Zorgvuldig om U de juiste Vapor ervaring te geven. <br> Wij zijn hier voor U als een vriend.<br>
			 Wij bieden verschillende oplossing op maat aan waar wij zeker van zijn dat er een oplossing voor U tussen zit.<br>Spring gerust even binnen in onze winkel aan de Grens overgang van Nispen/Roosendaal - Essen </p>
		 </div>
	 </div>
</div>
<!---->
		 <?php //cat Selection
		
									try {	
										$cat1 = $db->prepare("SELECT * FROM products WHERE cat = 'VAPORIZER' ORDER BY RAND() LIMIT 1");
										$cat2 = $db->prepare("SELECT * FROM products WHERE cat = 'E-SIGARETTEN' ORDER BY RAND() LIMIT 1");
										$cat3 = $db->prepare("SELECT * FROM products WHERE cat = 'LIQUIDS' ORDER BY RAND() LIMIT 1");
										$cat4 = $db->prepare("SELECT * FROM products WHERE cat = 'CLEAROMIZERS' ORDER BY RAND() LIMIT 1");
										$cat5 = $db->prepare("SELECT * FROM products WHERE cat = 'COILS' ORDER BY RAND() LIMIT 1");
																				$cat1->execute();
										$pid1 = $cat1->fetch(PDO::FETCH_ASSOC);
																				$cat2->execute();
										$pid2 = $cat2->fetch(PDO::FETCH_ASSOC);
																				$cat3->execute();
										$pid3 = $cat3->fetch(PDO::FETCH_ASSOC);
																				$cat4->execute();
										$pid4 = $cat4->fetch(PDO::FETCH_ASSOC);
																				$cat5->execute();
										$pid5 = $cat5->fetch(PDO::FETCH_ASSOC);
										$img1 = $db->prepare("SELECT * FROM images WHERE pid = :pid1 ORDER BY RAND() LIMIT 1");
										$img2 = $db->prepare("SELECT * FROM images WHERE pid = :pid2 ORDER BY RAND() LIMIT 1");
										$img3 = $db->prepare("SELECT * FROM images WHERE pid = :pid3 ORDER BY RAND() LIMIT 1");
										$img4 = $db->prepare("SELECT * FROM images WHERE pid = :pid4 ORDER BY RAND() LIMIT 1");
										$img5 = $db->prepare("SELECT * FROM images WHERE pid = :pid5 ORDER BY RAND() LIMIT 1");
																				$img1->execute(array(':pid1' => $pid1[id]));
										$imgid1 = $img1->fetch(PDO::FETCH_ASSOC);
																				$img2->execute(array(':pid2' => $pid2[id]));
										$imgid2 = $img2->fetch(PDO::FETCH_ASSOC);
																				$img3->execute(array(':pid3' => $pid3[id]));
										$imgid3 = $img3->fetch(PDO::FETCH_ASSOC);
																				$img4->execute(array(':pid4' => $pid4[id]));
										$imgid4 = $img4->fetch(PDO::FETCH_ASSOC);
																				$img5->execute(array(':pid5' => $pid5[id]));
										$imgid5 = $img5->fetch(PDO::FETCH_ASSOC);
									}
									catch(Exception $e) {
										echo '<h2><font color=red>';
										var_dump($e->getMessage());
										die ('</h2></font> ');
									}									
		//seo Namen
				$sp1 = strtolower(str_replace(" ", "-", $pid1[name]));
		$sm1 = strtolower($pid1[merk]);
				$sp2 = strtolower(str_replace(" ", "-", $pid2[name]));
		$sm2 = strtolower($pid2[merk]);
				$sp3 = strtolower(str_replace(" ", "-", $pid3[name]));
		$sm3 = strtolower($pid3[merk]);
				$sp4 = strtolower(str_replace(" ", "-", $pid4[name]));
		$sm4 = strtolower($pid4[merk]);
				$sp5 = strtolower(str_replace(" ", "-", $pid5[name]));
		$sm5 = strtolower($pid5[merk]);
								?>
<div class="bride-grids">
	 <div class="container">
		 <div class="col-md-4 bride-grid">
			 <div class="content-grid l-grids"> <!-- row 1-->
				 <figure class="effect-bubba">
		<a href="//<?php echo $_SERVER['SERVER_NAME'].'/'.$sm1.'/'.$sp1;?>.html">
						<img src="<?php echo ($imgid1[img]=="")?$defimg:$imgid1[img] ?>"  height="320" alt="<?php echo $pid1[name] ?>"/>
						<figcaption>
							<h4>Vaporizers</h4>
							<p>Voor het verbranden van planten/olie op hoge temperatuur zonder verlies van smaak </p>																
						</figcaption>			
				 </a>
				 </figure>
				 <div class="clearfix"></div>
				 <h3>Vaporizers</h3>
			 </div>
			 <div class="content-grid l-grids"> <!-- row 2-->
				 <figure class="effect-bubba">
				<a href="//<?php echo $_SERVER['SERVER_NAME'].'/'.$sm2.'/'.$sp2;?>.html">
						<img src="<?php echo ($imgid2[img]=="")?$defimg:$imgid2[img] ?>"  height="320" alt="<?php echo $pid2[name] ?>"/>
						<figcaption>
							<h4>Esigaretten</h4>
							<p>Ook bekend als Dampers, Vapors , Electrishe Sigaretten , dus gewoon een Module dat rook produceert en beter is dan een gewone sigarret </p>																
						</figcaption>
						</a>
				 </figure>
				 <div class="clearfix"></div>
				 <h3>E-Sigaretten</h3>
			 </div>
		 </div> <!--einde row 1 en 2 -->
		 <div class="col-md-4 bride-grid"> <!-- row 3-->
		 		<div class="content-grid l-grids">
						<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAP4AAADfCAIAAABZBPmVAAACZklEQVR4nO3SMQEAIAzAMMC/5yFjRxMFPXpn5kDP2w6AHdYnyvpEWZ8o6xNlfaKsT5T1ibI+UdYnyvpEWZ8o6xNlfaKsT5T1ibI+UdYnyvpEWZ8o6xNlfaKsT5T1ibI+UdYnyvpEWZ8o6xNlfaKsT5T1ibI+UdYnyvpEWZ8o6xNlfaKsT5T1ibI+UdYnyvpEWZ8o6xNlfaKsT5T1ibI+UdYnyvpEWZ8o6xNlfaKsT5T1ibI+UdYnyvpEWZ8o6xNlfaKsT5T1ibI+UdYnyvpEWZ8o6xNlfaKsT5T1ibI+UdYnyvpEWZ8o6xNlfaKsT5T1ibI+UdYnyvpEWZ8o6xNlfaKsT5T1ibI+UdYnyvpEWZ8o6xNlfaKsT5T1ibI+UdYnyvpEWZ8o6xNlfaKsT5T1ibI+UdYnyvpEWZ8o6xNlfaKsT5T1ibI+UdYnyvpEWZ8o6xNlfaKsT5T1ibI+UdYnyvpEWZ8o6xNlfaKsT5T1ibI+UdYnyvpEWZ8o6xNlfaKsT5T1ibI+UdYnyvpEWZ8o6xNlfaKsT5T1ibI+UdYnyvpEWZ8o6xNlfaKsT5T1ibI+UdYnyvpEWZ8o6xNlfaKsT5T1ibI+UdYnyvpEWZ8o6xNlfaKsT5T1ibI+UdYnyvpEWZ8o6xNlfaKsT5T1ibI+UdYnyvpEWZ8o6xNlfaKsT5T1ibI+UdYnyvpEWZ8o6xNlfaKsT5T1ibI+UdYnyvpEWZ8o6xNlfaKsT5T1ibI+UdYnyvpEWZ8o6xNlfaKsT5T1ibI+UdYnyvpEWZ8o6xNlfaKsT5T1ibI+UdYnyvpEWZ8o6xNlfaI+Re8Eu6ekYsUAAAAASUVORK5CYII="  height="100" alt="whitespace"/>
			 </div>
							 <div class="content-grid l-grids">
				 <figure class="effect-bubba">
				 <a href="//<?php echo $_SERVER['SERVER_NAME'].'/'.$sm3.'/'.$sp3;?>.html">
						<img src="<?php echo ($imgid3[img]=="")?$defimg:$imgid3[img] ?>"  height="480" alt="<?php echo $pid3[name] ?>"/>
						<figcaption>
							<h4>VloeiStoffen aka E-liquids</h4>
							<p>Veel rook of veel smaak , vloeistoffen bepalen een groot deel.<br>een goede vloeistof betekend een gegarandeerde smaak plezier en vapor plezier.<br>Er zijn verschillende soorten en smaken </p>																
						</figcaption>
					</a>						
				 </figure>
				 <div class="clearfix"></div>
				 <h3>E-Liquids</h3>
			 </div>
			 		 		<div class="content-grid l-grids">
						<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAP4AAADfCAIAAABZBPmVAAACZklEQVR4nO3SMQEAIAzAMMC/5yFjRxMFPXpn5kDP2w6AHdYnyvpEWZ8o6xNlfaKsT5T1ibI+UdYnyvpEWZ8o6xNlfaKsT5T1ibI+UdYnyvpEWZ8o6xNlfaKsT5T1ibI+UdYnyvpEWZ8o6xNlfaKsT5T1ibI+UdYnyvpEWZ8o6xNlfaKsT5T1ibI+UdYnyvpEWZ8o6xNlfaKsT5T1ibI+UdYnyvpEWZ8o6xNlfaKsT5T1ibI+UdYnyvpEWZ8o6xNlfaKsT5T1ibI+UdYnyvpEWZ8o6xNlfaKsT5T1ibI+UdYnyvpEWZ8o6xNlfaKsT5T1ibI+UdYnyvpEWZ8o6xNlfaKsT5T1ibI+UdYnyvpEWZ8o6xNlfaKsT5T1ibI+UdYnyvpEWZ8o6xNlfaKsT5T1ibI+UdYnyvpEWZ8o6xNlfaKsT5T1ibI+UdYnyvpEWZ8o6xNlfaKsT5T1ibI+UdYnyvpEWZ8o6xNlfaKsT5T1ibI+UdYnyvpEWZ8o6xNlfaKsT5T1ibI+UdYnyvpEWZ8o6xNlfaKsT5T1ibI+UdYnyvpEWZ8o6xNlfaKsT5T1ibI+UdYnyvpEWZ8o6xNlfaKsT5T1ibI+UdYnyvpEWZ8o6xNlfaKsT5T1ibI+UdYnyvpEWZ8o6xNlfaKsT5T1ibI+UdYnyvpEWZ8o6xNlfaKsT5T1ibI+UdYnyvpEWZ8o6xNlfaKsT5T1ibI+UdYnyvpEWZ8o6xNlfaKsT5T1ibI+UdYnyvpEWZ8o6xNlfaKsT5T1ibI+UdYnyvpEWZ8o6xNlfaKsT5T1ibI+UdYnyvpEWZ8o6xNlfaI+Re8Eu6ekYsUAAAAASUVORK5CYII="  height="100" alt="whitespace"/>
			 </div>
		 </div> <!--einde row 3 -->
		 <div class="col-md-4 bride-grid">
						 <div class="content-grid l-grids"> <!-- row 4-->
				 <figure class="effect-bubba">
				<a href="//<?php echo $_SERVER['SERVER_NAME'].'/'.$sm4.'/'.$sp4;?>.html">
						<img src="<?php echo ($imgid4[img]=="")?$defimg:$imgid4[img] ?>"  height="320" alt="<?php echo $pid4[name] ?>"/>
						<figcaption>
							<h4>Clearomisers aka Tanks</h4>
							<p>Zonder Tank kan je geen vloeistoff toevoegen , de Clearomiser is het hoofd onderdeel van de e-cigaret</p>																
						</figcaption>
						</a>
				 </figure>
				 <div class="clearfix"></div>
				 <h3>Tank - Clearomiser</h3>
			 </div>
						 <div class="content-grid l-grids"> <!-- row 5-->
				 <figure class="effect-bubba">
				 <a href="//<?php echo $_SERVER['SERVER_NAME'].'/'.$sm5.'/'.$sp5;?>.html">
						<img src="<?php echo ($imgid5[img]=="")?$defimg:$imgid5[img] ?>"  height="320" alt="<?php echo $pid5[name] ?>"/>
						<figcaption>
							<h4>Coils</h4>
							<p>De coils bepalen de hoeveelheid rook en de smaak , Sub Ohm coils ( onder 1 ohm) zijn voor DNL en de gewone coils zijn voor MNL ( 1ohm)<br>Verschillende soorten coils geven een verschillede soort ervaring </p>																
						</figcaption>
				</a>						
				 </figure>
				 <div class="clearfix"></div>
				 <h3>Coils</h3>
			 </div>
		 </div> <!--einde row 4 en 5 -->
		 <div class="clearfix"></div>
	 </div>
</div>
<!---->

<div class="featured">
	 <div class="container">
		 <h3>Onze Selectie Producten</h3>
		 <div class="feature-grids"> <!-- Random producten -->
		 <?php
		
									try {	
										$relprod2 = $db->prepare("SELECT * FROM products ORDER BY RAND() LIMIT 3");
										$relprod2->execute();
										$rel2 = $relprod2->fetchall(PDO::FETCH_ASSOC);
									foreach($rel2 as $related2) {
										$imgprod = $db->prepare("SELECT * FROM images WHERE pid = :pid ORDER BY RAND() LIMIT 1");
										$imgprod->execute(array(':pid' => $related2[id]));
										$img = $imgprod->fetch(PDO::FETCH_ASSOC);
													$seoproduct = str_replace(" ", "-", $related2[name]);
													$seoproduct = strtolower($seoproduct);
													$seomerk = strtolower($related2[merk]);
									?>
					 <a href="//<?php echo $_SERVER['SERVER_NAME'].'/'.$seomerk.'/'.$seoproduct;?>.html"><div class="product-grid love-grid">
						<div class="more-product"><span> </span></div>						
						<div class="product-img b-link-stripe b-animate-go  thickbox">
						<img src="<?php echo ($img[img]=="")?$defimg:$img[img] ?>" height="280" alt="<?php echo $related2['name'] ?>"/>
						</div>					
						<div class="product-info">
							<div class="product-info-cust prt_name">
								<h4><?php echo $related2['merk']." <br> ".$related2['name'] ?></h4>
								<div class="clearfix"> </div>								
							</div>													
						</div>
					</div></a>
								<?php
									}
									}
									catch(Exception $e) {
										echo '<h2><font color=red>';
										var_dump($e->getMessage());
										die ('</h2></font> ');
									}	
								?>
<div class="clearfix"></div>
</div>
 </div>
</div>
<!---->

<div class="shoping">
	 <div class="container">
		 <div class="shpng-grids">
			 <div class="col-md-4 shpng-grid">
				 <h3>Premium Levering</h3>
				 <p>Voor 14 uur besteld?<br>We leveren het vandaag nog</p>
			 </div>
			 <div class="col-md-4 shpng-grid">
				 <h3>Quality Service</h3>
				 <p>Wij staan altijd voor u klaar,<br>Bezoek ons vandaag nog</p>
			 </div>
			 <div class="col-md-4 shpng-grid">
				 <h3>Betalingen</h3>
				 <p>Via onze Fysieke Winkel,<br>Betaling via overschrijven,<br>99 andere Betaal opties</p>
			 </div>
			 <div class="clearfix"></div>
		 </div>
	 </div>
</div>