
extend = []
settlements = {}

with open("netesforras2.csv", "r", encoding="utf-8") as f:
    extend = f.read().split("\n")


for l in extend:
    if ";" in l:
        s = l.split(";")
        if len(s) == 2:
            varos, megye = s
            settlements[varos] = megye
        else:
            print(f"Hibás sor: {l}")


with open("locations.csv","r",encoding="utf-8") as f:
    locations = f.read().split("\n")

with open("locsAndCounties.csv", "w", encoding="utf-8") as f:
    f.write('')

with open("locsAndCounties.csv", "a", encoding="utf-8") as f:

    for l in locations:
        s = l.split(";")

        if len(s) == 3:

            sett = s[2]

            if "," in sett:
                print(sett,end="→")
                sett = sett[:sett.index(",")]
                print(sett)

            found = False

            for key, value in settlements.items():

                if key.strip() == sett.strip():
                    s.append(value)
                    found = True
                    break

            if not found:
                if "Budapest" in sett:
                    s.append("1")
                else:
                    s.append("NEMTALÁLTAMSEMMIT")

            s[2] = sett
            f.write(f"{';'.join(s)}\n")

        else:
            print(f"Hibás sor: {l}")




