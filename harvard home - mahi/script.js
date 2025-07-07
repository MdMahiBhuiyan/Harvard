let display = document.getElementById("display");

function append(value) {
  if (display.value === "0" && value !== ".") {
    display.value = value;
  } else {
    display.value += value;
  }
}

function del() {
  display.value = display.value.slice(0, -1) || "0";
}

function reset() {
  display.value = "0";
}

function calculate() {
  try {
    display.value = eval(display.value.replace(/x/g, "*"));
  } catch {
    display.value = "Error";
  }
}
