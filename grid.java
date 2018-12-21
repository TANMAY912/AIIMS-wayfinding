public class grid{

	public static void main(String[] args) {

		for(int i=0;i<60;i++){
			for (int j=0;j<60 ;j++ ) {
				char ch='"';
				int k =100*i + j;
			System.out.println("<div class=" + ch + "grid-item" + ch + " id = " + ch+k+ch + " onclick = " + ch +"clk(" + k +")" + ch + "></div>");
			}
			
		}
	}
}