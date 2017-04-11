package com.thepetronics.petro.fds;

/**
 * Created by MuhammadDanyal on 1/25/2016.
 */
class Charr {

    protected static final char S = ' ';

    protected static final char NL = '\n';

    protected static final char P = '+';

    protected static final char D = '-';

    protected static final char VL = '|';

    private final int x;

    private final int y;

    private final char c;

    protected Charr(int x, int y, char c) {
        this.x = x;
        this.y = y;
        this.c = c;
    }

    protected int getX() {
        return x;
    }

    protected int getY() {
        return y;
    }

    protected char getC() {
        return c;
    }

}

