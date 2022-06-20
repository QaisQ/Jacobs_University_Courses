function outputArg = Mrotation(M, anglex, angley, anglez)
outputArg = Tz(anglex)*Ty(angley)*Tx(anglez)*M;
end

