import {CircularProgressbar, buildStyles} from "react-circular-progressbar";
import "react-circular-progressbar/dist/styles.css";

type Props = {
    percentageUsed: number
}

export default function Progressbar({percentageUsed}: Props) {
    return (
        <CircularProgressbar
            value={percentageUsed}
            styles={buildStyles({
                pathColor: "#D2C3F6",
                textSize: 8,
                textColor: "#D2C3F6",
            })}
            text={`${percentageUsed}% Gastado`}
        />
    );
}
