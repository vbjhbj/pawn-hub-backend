


with open("locsAndCounties 2. – Merged.csv","r",encoding="utf-8") as f:
    source = f.read().split("\n")

l = []

i = 1

while i < len(source):

    sp = source[i].split(";")

    if len(sp) == 4:
        name = sp[2]

        if name not in l:
            l.append(name)
        else:
            print(f"Hiba: '{name}' egynél többször van benne!")

    else:
        print(f"Hibás sor: '{source[i]}'")

    i += 1


